<?php
namespace re\rgx;
/**
 * MySQL 数据库操作类
 * @author reginx
 */
class mysql_db extends database {

    /**
     * 数据库操作句柄
     * @var resource
     */
    private $_pdo  = null;

    /**
     * 配置信息
     * @var array
     */
    private $_conf = null;

    /**
     * SQL记录
     * @var array
     */
    private $_sql  = [];

    /**
     * 架构方法
     * @param array $conf
     */
    public function __construct ($conf) {
        ini_set('default_socket_timeout', 120);
        $this->_parse_config($conf);
        $this->_connect();
        $this->select_db($this->_conf['db']);
        // profile
        if (isset($this->_conf['profiling']) && $this->_conf['profiling']) {
            $this->profiling = true;
            $this->_pdo->query('set profiling_history_size = 100');
            $this->_pdo->query('set profiling = on');
        }
    }

    /**
     * sleep 魔术方法
     * @return NULL
     */
    public function __sleep () {
        return null;
    }

    /**
     * 获取 SQL 记录
     * {@inheritDoc}
     * @see \re\rgx\database::get_sql()
     */
    public function get_sql () {
        return $this->_sql;
    }

    /**
     * 添加SQL记录
     * @param unknown $sql
     */
    public function add_sql ($sql) {
        if (RUN_MODE == 'debug') {
            $this->_sql[] = is_array($sql) ? join("\n\n", $sql) : $sql;
        }
    }

    /**
     * 连接数据库
     * @throws exception
     */
    private function _connect () {
        try {
            $dsn = "mysql:host={$this->_conf['host']};port={$this->_conf['port']};charset={$this->_conf['charset']}";
            $this->_pdo = new \PDO($dsn, $this->_conf['user'], $this->_conf['passwd']);
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\Exception $e) {
            LOGS('db', $e->__toString());
            throw new exception(LANG('service connection failed', 'MySQL', $e->getMessage()), 
                exception::CONFIG_ERROR);
        }
    }

    /**
     * 解析数据库连接配置
     * @param array $conf
     * @throws exception
     */
    private function _parse_config ($conf) {
        // @todo read, write
        if (!isset($conf['default'])) {
            throw new exception(LANG('config error', 'MySQL DSN'), exception::CONFIG_ERROR);
        }
        parse_str(str_replace(';', '&', $conf['default']), $this->_conf);
    }

    /**
     * 执行查询
     * {@inheritDoc}
     * @see \re\rgx\database::query()
     */
    public function query ($sql) {
        $this->profile['reads'] ++;
        $this->profile['totals'] ++;
        try {
            $this->add_sql($sql);
            $ret = $this->_pdo->query($sql);
        }
        catch (\PDOException $e) {
            LOGS('db', $e->__toString());
            throw new exception(LANG('sql query fails', $this->get_error(), $sql), 
                exception::SQL_QUERY_ERROR, true);
        }
        return $ret;
    }

    /**
     * 执行
     * {@inheritDoc}
     * @see \re\rgx\database::exec()
     */
    public function exec ($sql, $callback = null) {
        try {
            $this->add_sql($sql);
            $ret = $this->_pdo->exec($sql);
            $this->profile['writes'] ++;
            $this->profile['totals'] ++;
            if (is_callable($callback)) {
                try {
                    $callback($ret);
                }
                catch (\Exception $e) {
                    LOGS('db', $e->__toString());
                    throw new exception(LANG('invalid callback'), exception::INVALID_CALLBACK, true);
                }
            }
        }
        catch (\PDOException $e) {
            LOGS('db', $e->__toString());
            throw new exception(LANG('sql query fails', $this->get_error(), $sql), 
                exception::SQL_QUERY_ERROR, true);
        }
        return $ret ?: null;
    }

    /**
     * 执行事务
     * {@inheritDoc}
     * @see \re\rgx\database::transaction()
     */
    public function transaction ($sql_list = []) {
        $ret = true;
        if (empty($sql_list)) {
            throw new exception(LANG('no data', "transaction sql list"), 
                exception::SQL_QUERY_ERROR);
        }
        $this->add_sql($sql_list);
        try {
            $this->_pdo->beginTransaction();
            foreach ($sql_list as $v) {
                $this->_pdo->exec($v);
            }
            $this->profile['writes'] ++;
            $this->profile['totals'] ++;
            $this->_pdo->commit();
        }
        catch (\PDOException $e) {
            LOGS('db', $e->__toString() . PHP_EOL . join(PHP_EOL, $sql_list));
            $this->_pdo->rollback();
            $ret = false;
        }
        return $ret;
    }

    /**
     * 选择数据库
     * {@inheritDoc}
     * @see \re\rgx\database::select_db()
     */
    public function select_db ($db) {
        try {
            $this->_pdo->exec("use {$db}");
        }
        catch (\Exception $e) {
            LOGS('db', $e->__toString());
            throw new exception($e->getMessage(), exception::SQL_QUERY_ERROR, true);
        }
    }

    /**
     * 设置会话编码
     * {@inheritDoc}
     * @see \re\rgx\database::set_charset()
     */
    public function set_charset ($charset = 'utf8') {
        try {
            $this->_pdo->exec("set names {$charset}");
        }
        catch (\Exception $e) {
            LOGS('db', $e->__toString());
            throw new exception($e->getMessage(), exception::SQL_QUERY_ERROR, true);
        }
    }

    /**
     * 获取错误描述
     * {@inheritDoc}
     * @see \re\rgx\database::get_error()
     */
    public function get_error () {
        $error = $this->_pdo->errorInfo();
        return $error ? join("#", [$error[1], $error[2]]) : '';
    }

    /**
     * 获取单条记录
     * {@inheritDoc}
     * @see \re\rgx\database::get()
     */
    public function get ($sql, $quiet = false, $callback = false) {
        $ret = $this->query($sql);
        if (!$ret) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        $ret = $ret->fetch(\PDO::FETCH_ASSOC);
        return is_callable($callback) && !empty($ret) ? $callback($ret) : $ret;
    }

    /**
     * 获取多条记录
     * {@inheritDoc}
     * @see \re\rgx\database::get()
     */
    public function get_all ($sql, $key = null, $quiet = false, $callback = false) {
        $ret = [];
        $query = $this->query($sql);
        if (!$query) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        if ($key !== null) {
            while (($row = $query->fetch(\PDO::FETCH_ASSOC)) != false) {
                if (isset($row[$key])) {
                    $ret[$row[$key]] = is_callable($callback) ? $callback($row) : $row;
                }
                else {
                    $ret[] = is_callable($callback) ? $callback($row) : $row;
                }
            }
        }
        else {
            $ret = $query->fetchAll(\PDO::FETCH_ASSOC);
            if (is_callable($callback) && !empty($ret)) {
                $ret = array_map($callback, $ret);
            }
        }
        return $ret;
    }

    /**
     * 更新
     * {@inheritDoc}
     * @see \re\rgx\database::update()
     */
    public function update ($sql, $quiet = false) {
        $ret = [
            'code' => 1,
            'rows' => 0
        ];
        $rows = $this->exec($sql);
        $ret['code'] = $rows === false ? 1 : 0;
        $ret['rows'] = $rows === false ? 0 : $rows;
        if ($rows === false && !$quiet) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        return $ret;
    }

    /**
     * 新增
     * {@inheritDoc}
     * @see \re\rgx\database::insert()
     */
    public function insert ($sql, $quiet = false) {
        $ret = [
            'code' => 1,
            'rows' => 0
        ];
        $rows = $this->exec($sql);
        $ret['code'] = $rows === false ? 1 : 0;
        $ret['rows'] = $rows === false ? 0 : $rows;
        $ret['row_id'] = $rows === false ? 0 : $this->_pdo->lastInsertId();
        if ($rows === false && !$quiet) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        return $ret;
    }

    /**
     * 删除
     * {@inheritDoc}
     * @see \re\rgx\database::delete()
     */
    public function delete ($sql, $quiet = false) {
        $ret = [
            'code' => 1,
            'rows' => 0
        ];
        $rows = $this->exec($sql);
        $ret['code'] = $rows === false ? 1 : 0;
        $ret['rows'] = $rows === false ? 0 : $rows;
        if ($rows === false && !$quiet) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        return $ret;
    }

    /**
     * 获取记录第一个字段
     *
     * @param string $sql
     * @param string $type
     * @return integer
     */
    public function fetch ($sql, $quiet = false, $callback = false) {
        $query = $this->query($sql);
        if (!$query) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            if (!$quiet) {
                throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                    exception::SQL_QUERY_ERROR);
            }
        }
        if (is_callable($callback)) {
            $callback();
        }
        return $query->fetchColumn();
    }

    /**
     * 调用
     * {@inheritDoc}
     * @see \re\rgx\database::call()
     */
    public function call ($sql, $callback = false) {
        $query = $this->query($sql);
        if (!$query) {
            $error = $this->get_error();
            LOGS('db', [$error, PHP_EOL . $sql], true);
            throw new exception(LANG('sql query fails', $error , RUN_MODE == 'debug' ? $sql : ''), 
                exception::SQL_QUERY_ERROR);
        }
        $result = $query->fetch(\PDO::FETCH_ASSOC);
        if (is_callable($callback)) {
            $result = $callback($result);
        }
        return $result;
    }

    /**
     * 获取分析报告
     * {@inheritDoc}
     * @see \re\rgx\database::get_profile()
     */
    public function get_profile ($id = null) {
        $ret = $this->profile;
        if ($this->profiling) {
            $ret['trace'] = [];
            $ret['duration'] = 0.0;
            // 获取单条详细
            if (is_numeric($id)) {
                return $this->get_all("show profile for query {$id}");
            }
            else {
                $ret['trace'] = $this->get_all('show profiles');
                foreach ((array)$ret['trace'] as $v) {
                    $ret['duration'] += $v['Duration'] * 1000;
                }
            }
        }
        return $ret;
    }
}