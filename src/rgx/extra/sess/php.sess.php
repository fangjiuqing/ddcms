<?php
namespace re\rgx;
/**
 * 默认PHP的sesssion实现
 * @author reginx
 */
class php_sess extends sess {

    /**
     * 配置信息
     * @var array
     */
    protected $config = [];

    /**
     * 架构函数
     * @param array $conf
     * @param string $sess_name
     * @param string $sess_id
     * @param array $extra
     */
    public function __construct ($conf, $sess_name = null, $sess_id = null, $extra = []) {
        $this->config = $conf;
        session_set_cookie_params($this->config['ttl'] ?: 1800 , '/', parent::get_domain());
        $sess_name = $sess_name ? session_name($sess_name) : session_name();
        if (!empty($sess_id)) {
            session_id($sess_id);
        }
        else if (isset($_COOKIE[$sess_name]) && 
                preg_match('/^RS\d{1,3}\-[\w\-]+$/i', $_COOKIE[$sess_name])) {
            $sess_id = $_COOKIE[$sess_name];
            session_id($_COOKIE[$sess_name]);
        }
        else {
            $sess_id = 'RS' . sprintf('%03d-', explode('.', $_SERVER['SERVER_ADDR'])[0]) . 
                            md5(app::get_ip() . $_SERVER['HTTP_USER_AGENT'] . mt_rand(1000000, 9999999));
            session_id($sess_id);
        }
        session_start($extra);
        if ($conf['cache']) {
            header("Cache-control: private"); // 使用http头控制缓存
        }
    }

    /**
     * 获取配置信息
     * {@inheritDoc}
     * @see \re\rgx\sess::get_config()
     */
    public function get_config () {
        return array(
            'id'        => session_id(),
            'name'      => session_name(),
            'expires'   => $this->config['ttl'] ?: 1800
        );
    }

    /**
     * 获取 session ID
     * {@inheritDoc}
     * @see \re\rgx\sess::sess_id()
     */
    public function sess_id () {
        return session_id();
    }

    /**
     * GC
     * {@inheritDoc}
     * @see \re\rgx\sess::gc()
     */
    public function gc () {}

    /**
     * 获取值
     * {@inheritDoc}
     * @see \re\rgx\sess::get()
     */
    public function get ($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * 设置值
     * {@inheritDoc}
     * @see \re\rgx\sess::set()
     */
    public function set ($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * 删除值
     * {@inheritDoc}
     * @see \re\rgx\sess::del()
     */
    public function del ($key) {
        $key = is_array($key) ? $key : [$key];
        foreach ($key as $v) {
            $_SESSION[$v] = null;
        }
    }

    /**
     * 是否存在项
     * {@inheritDoc}
     * @see \re\rgx\sess::exists()
     */
    public function exists ($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * 销毁会话
     * {@inheritDoc}
     * @see \re\rgx\sess::remove()
     */
    public function remove () {
        return session_destroy();
    }
}