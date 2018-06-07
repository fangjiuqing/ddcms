<?php
namespace re\rgx;
/**
 * 基于 Redis session 实现
 * @author reginx
 */
class redis_sess extends sess {

    /**
     * 存储域
     * @var string
     */
    private $_uuid = null;

    /**
     * Cookie key
     * @var string
     */
    private $_ckey = '';

    /**
     * Redis 操作对象
     * @var \Redis
     */
    private $_redis = null;

    /**
     * GC 概率配置
     * @var array
     */
    private $_gc    = [1, 100];

    /**
     * 默认生存周期
     * @var number
     */
    private $_ttl   = 1800;

    /**
     * 架构函数
     * @param array  $conf
     * @param string $sess_name
     * @param string $sess_id
     * @throws exception
     */
    public function __construct ($conf, $via = 'cookie', $sess_name = null, $sess_id = null) {
        if (!class_exists('\Redis', false)) {
            throw new exception(LANG('does not support', '\Redis '), exception::NOT_EXISTS);
        }
        $this->_gc   = empty($conf['gc']) ? $this->_gc : $conf['gc'];
        $this->_ttl  = $conf['ttl'] ? intval($conf['ttl']) : $this->_ttl;
        $this->_ckey = empty($sess_name) ? session_name() : $sess_name;

        $this->_redis = new \Redis();
        // connect
        if ($this->_redis->connect($conf['host'], $conf['port'])) {
            $this->_redis->select(intval($conf['db']));
        }
        else {
            throw new exception(LANG('config error', 'Redis'), exception::CONFIG_ERROR);
        }

        if ($via == 'cookie') {
            $this->_uuid = empty($sess_id) ? (isset($_COOKIE[$this->_ckey]) ? $_COOKIE[$this->_ckey] : '') : $sess_id;
        }
        else if ($via == 'header') {
            $this->_uuid = empty($sess_id) ? (
                isset($_SERVER[strtoupper('http_' . $this->_ckey)]) ? $_SERVER[strtoupper('http_' . $this->_ckey)] : ''
            ) : $sess_id;
        }

        if (!preg_match('/^RS\d{1,3}\-[\w\-]+$/i', $this->_uuid)) {
            $this->_uuid = $this->generate_sess_id();
        }

        // 更新 session 开始时间
        $this->set('RGX_DATE', REQUEST_TIME);

        if ($via == 'cookie') {
            // 更新 cookie ttl , + 30min
            setcookie($this->_ckey, $this->_uuid, REQUEST_TIME + $this->_ttl , "/" , parent::get_domain());
        }
        else if ($via == 'header') {
            header("{$this->_ckey}: {$this->_uuid}");
        }

        header("Cache-control: private"); // 使用http头控制缓存

        // GC
        $this->gc();
    }


    /**
     * 生成会话ID
     * @return [type] [description]
     */
    public function generate_sess_id () {
        return 'RS' . sprintf('%03d-', explode('.', $_SERVER['SERVER_ADDR'])[0]) . 
                md5(app::get_ip() . $_SERVER['HTTP_USER_AGENT'] . mt_rand(1000000, 9999999));
    }

    /**
     * GC 实现
     * {@inheritDoc}
     * @see \re\rgx\sess::gc()
     */
    public function gc () {
        $date = $this->get('RGX_DATE');
        // 已过期
        if (!$date && $date + $this->_ttl < REQUEST_TIME) {
            $this->remove();
            // 记录 GC 任务
            $this->_redis->rPush('gc_task', $this->_uuid);
        }
        // GC
        if (mt_rand(0, $this->_gc[1]) <= $this->_gc[0]) {
            // delete 10 rows each time
            $tasks = (array)$this->_redis->lRange('gc_task', 0, 20);
            foreach ($tasks as $v) {
                $date = $this->_redis->hGet($v, 'RGX_DATE');
                if (!$date || $date + $this->_ttl < REQUEST_TIME) {
                    // rm data
                    $this->_redis->del($v);
                    // rm task
                    $this->_redis->lRem('gc_task', $v, 0);
                }
            }
        }
        $this->set('RGX_DATE', REQUEST_TIME);
    }

    /**
     * 获取 session ID
     * {@inheritDoc}
     * @see \re\rgx\sess::sess_id()
     */
    public function sess_id () {
        return $this->_uuid;
    }

    /**
     * 获取当前配置信息
     * {@inheritDoc}
     * @see \re\rgx\sess::get_config()
     */
    public function get_config () {
        return array(
            'id'        => $this->_ckey,
            'name'      => $this->_uuid,
            'expires'   => 1800
        );
    }

    /**
     * 获取值
     * {@inheritDoc}
     * @see \re\rgx\sess::get()
     */
    public function get ($key) {
        $ret = $this->_redis->hExists($this->_uuid, $key) ? 
                $this->_redis->hGet($this->_uuid, $key) : null;
        if (!empty($ret)) {
            if (in_array(substr($ret, 0, 2), ['a:', 's:', 'i:', 'd:', 'N;', 'b:', 'O:'])
                    && in_array(substr($ret, -1), [';', '}'])) {
                $ret = unserialize($ret);
            }
        }
        return $ret;
    }

    /**
     * 设置值
     * {@inheritDoc}
     * @see \re\rgx\sess::set()
     */
    public function set ($key, $value) {
        if (is_array($value)) {
            $value = serialize($value);
        }
        return $this->_redis->hSet($this->_uuid, $key, $value);
    }

    /**
     * 删除值
     * {@inheritDoc}
     * @see \re\rgx\sess::del()
     */
    public function del ($key) {
        $key = is_array($key) ? $key : [$key];
        foreach ($key as $v) {
            $this->_redis->hDel($this->_uuid, $v);
        }
    }

    /**
     * 是否存在项
     * {@inheritDoc}
     * @see \re\rgx\sess::exists()
     */
    public function exists ($key) {
        return $this->_redis->hExists($this->_uuid, $key);
    }

    /**
     * 销毁
     * {@inheritDoc}
     * @see \re\rgx\sess::remove()
     */
    public function remove () {
        // 设置 cookie 过期
        unset($_COOKIE[$this->_ckey]);
        setcookie($this->_ckey, null, -1);
        $this->_redis->lRem('gc_task', $this->_uuid, 0);
        return $this->_redis->del($this->_uuid);
    }

    /**
     * 析构方法
     */
    public function __destruct () {
        if ($this->_redis) {
            $this->_redis->close();
        }
    }
}