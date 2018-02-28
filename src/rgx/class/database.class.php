<?php
namespace re\rgx;
/**
 * 数据库访问接口抽象类
 * @author reginx
 */
abstract class database {

    /**
     * 是否开启概况描述
     * @var bool
     */
    public $profiling = false;

    /**
     * 概况
     * @var array
     */
    public $profile   = [
        'totals'    => 0,
        'reads'     => 0,
        'writes'    => 0,
        'trace'     => []
    ];

    /**
     * 获取数据操作实例
     * @param array $conf
     * @throws exception
     * @return \re\rgx\database
     */
    public static final function get_instance ($conf = []) {
        static $dbobj = null;
        if (empty($dbobj)) {
            if (empty($conf)) {
                throw new exception(LANG('config error', 'database'), exception::NOT_EXISTS);
            }
            if (RUN_MODE == 'debug') {
                $file = RGX_PATH . 'extra/db/' . $conf['type'] . '.db.php';
                if (!is_file($file)) {
                    throw new exception(LANG('driver file not found', $conf['type']), exception::NOT_EXISTS);
                }
                include($file);
            }
            $class = __NAMESPACE__ . "\\" . $conf['type'] . '_db';
            $dbobj = new $class($conf[$conf['type']]);
        }
        return $dbobj;
    }

    /**
     * 选择数据库
     * @param string $db
     */
    abstract public function select_db ($db);

    /**
     * 执行查询
     * @param unknown $sql
     */
    abstract public function query ($sql);

    /**
     * 获取单条记录
     * @param string $sql
     * @param bool   $quiet
     * @param mixed  $callback
     */
    abstract public function get ($sql, $quiet = false, $callback = false);

    /**
     * 获取多条记录
     * @param string $sql
     * @param string $key
     * @param string $quiet
     * @param mixed  $callback
     */
    abstract public function get_all ($sql, $key = null, $quiet = false, $callback = false);

    /**
     * 获取错误描述
     */
    abstract public function get_error ();

    /**
     * 更新
     * @param string $sql
     * @param bool   $quiet
     */
    abstract public function update ($sql, $quiet = false);

    /**
     * 新增
     * @param string  $sql
     * @param bool    $quiet
     */
    abstract public function insert ($sql, $quiet = false);

    /**
     * 删除
     * @param unknown $sql
     * @param string $quiet
     */
    abstract public function delete ($sql, $quiet = false);

    /**
     * 获取单条单字段
     * @param string $sql
     * @param string $quiet
     */
    abstract public function fetch ($sql, $quiet = false, $callback = false);

    /**
     * 执行SQL
     * @param string    $sql
     * @param callable  $callback
     */
    abstract public function exec ($sql, $callback = null);

    /**
     * 执行事务
     * @param array $sql
     */
    abstract public function transaction ($sql_list = []);

    /**
     * 设置编码
     * @param string $charset
     */
    abstract public function set_charset ($charset = 'utf8');

    /**
     * 获取查询SQL记录
     */
    abstract public function get_sql ();
    
    /**
     * 调用
     * @param string $sql
     * @param callable $callback
     */
    abstract public  function call ($sql, $callback = null);

    /**
     * 获取sql执行报告
     * @param mixed $id
     */
    abstract public function get_profile ($id = null);
}