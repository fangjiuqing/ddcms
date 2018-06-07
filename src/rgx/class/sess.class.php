<?php
/**
 * session 抽象接口
 * @copyright reginx.com
 * $Id: sess.class.php 5 2017-07-19 03:44:30Z reginx $
 */
namespace re\rgx;

abstract class sess {

    /**
     * 获取项目值
     *
     * @param unknown_type $key
     */
    abstract protected function get ($key);
    
    /**
     * 获取当前配置信息 (sess_name, sess_id, expires)
     *
     */
    abstract protected function get_config ();
    
    /**
     * 设置项目值
     *
     * @param unknown_type $key
     * @param unknown_type $value
     */
    abstract protected function set ($key, $value);
    
    /**
     * 是否存在某项
     *
     * @param unknown_type $key
     */
    abstract protected function exists ($key);
    
    /**
     * 获取回话ID
     *
     */
    abstract protected function sess_id ();
    
    /**
     * 删除项目值
     *
     * @param unknown_type $key
     */
    abstract protected function del ($key);
    
    /**
     * 删除会话
     *
     */
    abstract protected function remove ();
    
    
    /**
     * GC
     *
     */
    abstract protected function gc ();

    /**
     * 获取域名
     * @return string
     */
    public static final function get_domain () {
        static $_domain = null;
        if (empty($_domain)) {
            $domain = explode(':', $_SERVER['HTTP_HOST'])[0];
            if (!filter_var($domain, FILTER_VALIDATE_IP)) {
                if (substr_count($domain, '.') >= 2 ){
                    $_domain = substr($domain, strpos($domain, '.'));
                }
                else {
                    $_domain = '.' . $domain;
                }
            }
            else {
                $_domain = $domain;
            }
        }
        return $_domain;
    }

    /**
     * 获取 sess 操作对象
     *
     * @param unknown_type $conf
     * @return unknown
     */
    public static final function get_instance($conf, $sess_name = null, $sess_id = null, $extra = []) {
        static $sobj = null;
        if (empty($sobj)) {
            $type = $conf['type'] ? $conf['type'] : 'php';
            if (RUN_MODE == 'debug') {
                $file = RGX_PATH . 'extra/sess/' . $type . '.sess.php';
                if (!is_file($file)) {
                    throw new exception(LANG('driver file not found', "{$conf['type']}_sess"), exception::NOT_EXISTS);
                }
                include ($file);
            }
            $class = __NAMESPACE__ . "\\" . $type . '_sess';
            $sobj = new $class($conf[$conf['type']], $conf['via'] ?: 'cookie', $sess_name, $sess_id, $extra);
        }
        return $sobj;
    }

    /**
     * 设置 Cookie
     * @param [type]  $k    [description]
     * @param [type]  $v    [description]
     * @param integer $ttl  [description]
     * @param string  $path [description]
     */
    public static function set_cookie ($k, $v, $ttl = 0, $path = '/') {
        setcookie($k, $v, $ttl , $path , self::get_domain());
    }
}