<?php
namespace re\rgx;

/**
 * 消息队列抽象类
 * @author reginx
 */
class redis_mq extends mq {

    /**
     * redis 操作对象
     * @var null
     */
    private $_redis = null;

    /**
     * 架构函数
     * @param array  $conf
     * @param string $sess_name
     * @param string $sess_id
     * @throws exception
     */
    public function __construct ($conf, $sess_name = null, $sess_id = null) {
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

        // 域
        $this->_uuid = empty($sess_id) ? (isset($_COOKIE[$this->_ckey]) ? $_COOKIE[$this->_ckey] : '') : $sess_id;
        if (!preg_match('/^RS\d{1,3}\-[\w\-]+$/i', $this->_uuid)) {
            // 新的 session 
            $this->_uuid = 'RS' . sprintf('%03d-', explode('.', $_SERVER['SERVER_ADDR'])[0]) . 
                            md5(app::get_ip() . $_SERVER['HTTP_USER_AGENT'] . mt_rand(1000000, 9999999));
        }
        // 更新 session 开始时间
        $this->set('RGX_DATE', REQUEST_TIME);

        header("Cache-control: private"); // 使用http头控制缓存
        // 更新 cookie ttl , + 30min
        setcookie($this->_ckey, $this->_uuid, REQUEST_TIME + $this->_ttl , "/" , parent::get_domain());
        // GC
        $this->gc();
    }

    /**
     * 入栈
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function push ($key, $value);

    /**
     * 出栈
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function pop ($key);

    /**
     * 删除任务
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function remove ($key);
}