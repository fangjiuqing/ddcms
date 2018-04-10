<?php
namespace re\rgx;
/**
 * app 基类
 * @author reginx
 */
class app extends rgx {
    
    /**
     * 模块操作实例
     * @var \re\rgx\module
     */
    private static $_mod = null;

    /**
     * 模板操作实例
     * @var \re\rgx\template
     */
    private static $_tpl = null;

    /**
     * 缓存操作实例
     * @var \re\rgx\cache
     */
    private static $_cache = null;

    /**
     * 数据库操作实例
     * @var \re\rgx\database
     */
    private static $_db = null;
    
    /**
     * 日志操作实例
     * @var \re\rgx\log
     */
    private static $_log = null;
    
    /**
     * 会话操作实例
     * @var \re\rgx\sess
     */
    private static $_sess = null;
    
    /**
     * 初始化
     */
    public static function init () {
        $offset = CFG('app.timezone');
        // timezone
        date_default_timezone_set('Etc/GMT' . ($offset > 0 ? '-' : '+') . (abs($offset)));
        // app url
        define('APP_URL', app::get_url());
        define('BASE_URL', app::get_base_url());
        define('DATA_URL',  BASE_URL . 'data/');
        define('UPLOAD_URL', CFG('upload_url') ?: (DATA_URL . 'attachment/'));
        define('STATIC_URL', CFG('static_url') ?: (BASE_URL . 'static/'));
        // defines
        foreach ((array)CFG('defines') as $key => $val) {
            define(strtoupper($key), $val);
        }
        // router init
        IS_CLI ? router::parse_cli() : router::parse((CFG('route') ?: []) + parse_url(APP_URL));

        self::$_tpl = template::get_instance(CFG('tpl') ?: []);
        self::$_cache = cache::get_instance(CFG('cache') ?: []);

        $mod_class  = router::get_mod();
        $act_method = router::get_act();
        // class name verify
        if (!preg_match('/^[a-z][a-z0-9\_]*$/i', $mod_class)) {
            self::tpl()->display(CFG('route.404_tpl'));
        }

        if (!IS_CLI || !getenv('request_hold')) {
            $mod_class  = NS . "\\" . $mod_class;
            self::$_mod = new $mod_class();

            // 404
            if(!method_exists(self::$_mod, $act_method) && !method_exists(self::$_mod, '__call')) {
                self::$_mod->show_404(LANG('not exists', "{$mod_class}::{$act_method}"));
            }
            else {
                self::$_mod->$act_method();
            }
        }
    }
    
    /**
     * 获取数据库操作实例
     * @return \re\rgx\database
     */
    public static function db () {
        if (self::$_db === null) {
            self::$_db = database::get_instance((CFG('db') ?: []));
        }
        return self::$_db;
    }
    
    /**
     * 获取模板操作实例
     * @return \re\rgx\template
     */
    public static function tpl () {
        if (self::$_tpl === null) {
            self::$_tpl = template::getobj(CFG('tpl') ?: []);
        }
        return self::$_tpl;
    }

    /**
     * 获取缓存操作实例
     * @return \re\rgx\cache
     */
    public static function cache () {
        if (self::$_cache === null) {
            self::$_cache = cache::get_instance(CFG('cache') ?: []);
        }
        return self::$_cache;
    }

    /**
     * 获取缓存操作实例
     * @param string $mod
     * @param string $callback
     * @return \re\rgx\log
     */
    public static function log ($mod = 'common', $callback = false) {
        if (self::$_log[$mod] === null) {
            self::$_log[$mod] = log::get_instance(CFG('log') ?: [], 
                is_callable($callback) ? $callback : function ($obj) use ($mod) {
                $obj->init($mod);
            });
        }
        return self::$_log[$mod];
    }
    
    /**
     * 获取sess操作实例
     * @param string $skey
     * @param string $sid
     * @param array $opts
     * @return \re\rgx\sess
     */
    public static function sess ($skey = null, $sid = null, $opts = []) {
        if (self::$_sess === null) {
            self::$_sess = sess::get_instance(CFG('sess'), $skey, $sid, $opts);
        }
        return self::$_sess;
    }
    
    /**
     * 自动加载
     * @param string $class
     * @throws exception
     */
    public final static function loader ($class) {
        $class = str_replace(NS . '\\', '', $class);
        $class = str_replace('re\\rgx\\', '', $class);
        $paths = explode('_', $class);
        $name  = array_shift($paths);
        if (empty($paths)) {
            throw new exception(LANG('not exists', 'file ' . $class), exception::NOT_EXISTS);
        }
    
        $type  = array_pop($paths);
        if (!in_array($type, array('lib', 'log', 'cls', 'module', 'table', 'block', 'iface', 'test', 'helper'))) {
            throw new exception(LANG('auto load not allowed', $type), exception::AUTO_LOAD_NOT_ALLOWED);
        }
        if (!empty($paths)) {
            $file = $type . DS . $name . DS . join(DS, $paths) . '.' . $type . '.php';
        }
        else {
            $file = $type . DS . $name . '.' . $type . '.php';
        }
        $file = (in_array($type, array('module', 'iface', 'test')) ? APP_PATH : INC_PATH) . $file;
        if (!is_file($file)) {
            if ($type == 'module') {
                app::tpl()->assign('msg', LANG('404 not found'));
                app::tpl()->display(CFG('tpl.404_tpl'), 'text/html', ['HTTP/1.1 404']);
            }
            else {
                throw new exception(LANG('not exists', misc::relpath($file)), exception::NOT_EXISTS);
            }
        }
        include ($file);
    }
    
    /**
     * 获取 app 访问 url
     * @return string
     */
    public static function get_url () {
        $app_url = CFG('app_url') ?: getenv('app_url');
        if (empty($app_url)) {
            $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            $dir = substr($dir, -1) == '/' ? substr($dir, 0, -1) : $dir;
            $dir = $dir == '/' ? '' : $dir;
            $app_url = ($_SERVER['REQUEST_SCHEME'] ?: 'http') . "://" . $_SERVER['HTTP_HOST'] . "{$dir}/";
        }
        return $app_url;
    }
    
    /**
     * 获取 app 站点 url
     * @return string
     */
    public static function get_base_url () {
        $ret = APP_NAME == 'default' ? APP_URL : (dirname(APP_URL) . '/');
        if (IS_ALIAS) {
            $def_domain = CFG('route.def_domain');
            $ret = CFG('route.protocol') . ($def_domain ? '' : ($def_domain . '.')) . CFG('route.rootdomain');
        }
        return $ret;
    }
    
    /**
     * 获取当前时间
     * @return integer
     */
    public static function get_time () {
        return IS_CLI ? time() : REQUEST_TIME;
    }
    
    /**
     * 获取 IP 地址
     * @return mixed
     */
    public static function get_ip () {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            }
            else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            }
            else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        }
        return filter_var(isset($ip) ? $ip : '0.0.0.0', FILTER_VALIDATE_IP);
    }

    /**
     * 获取实例
     * @param string $code
     * @param bool   $single
     * @param mixed  $extra
     * @return \re\rgx\rgx
     */
    public static function get_instance ($code, $single = true, $extra = null) {
        static $objbus = [];
        if (($pos = strripos($code, '_')) !== false) {
            // 添加命名空间
            if (!in_array(substr($code, $pos + 1), ['table', 'cls', 'iface', 'lib', 'helper'])) {
                $class = NS . '\\' . $code;
            }
            else {
                $class = 're\\rgx\\' . $code;
            }
        }
        if ($single) {
            if (!isset($objbus[$class])) {
                $objbus[$class] = new delegate($code, new $class($extra));
            }
            return $objbus[$class];
        }
        return new delegate($class, new $class($extra));
    }
    
    /**
     * 判断 模块文件是否存在
     * @param string $name
     * @param string $module
     * @return boolean
     */
    public static function module_file_exists ($name, $module = 'module') {
        return file_exists(APP_PATH . $module . DS . $name . ".{$module}.php");
    }
    
    /**
     * 命令行输出
     * @param unknown $msg
     */
    public static function cli_msg ($msg) {
        $temp  = PHP_EOL;
        $temp .= "+ ---------------------- RGX CLI ----------------------" . PHP_EOL;
        $temp .= "| @time\t" . date('Y-m-d H:i:s', app::get_time()) . PHP_EOL;
        $temp .= "| @uri\t" . getenv('request_uri') . PHP_EOL;
        $temp .= "| @message" . PHP_EOL;
        $temp .= "+ -----------------------------------------------------" . PHP_EOL;
        $temp .= (is_array($msg) ? ("| # " . join(PHP_EOL . "| # ", $msg)) : ("| # " . $msg)) . PHP_EOL;
        $temp .= "+ -----------------------------------------------------" . PHP_EOL;
        $temp .= PHP_EOL;
        exit($temp);
    }
}
