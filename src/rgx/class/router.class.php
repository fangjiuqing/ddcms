<?php
namespace re\rgx;
/**
 * 路由类
 * @author reginx
 */
class router extends rgx {

    /**
     * 模块名称
     * @var string
     */
    private static $_mod = 'index';

    /**
     * 动作名称
     * @var string
     */
    private static $_act = 'index';

    /**
     * 请求参数
     * @var array
     */
    private static $_request_params = [];

    /**
     * 获取请求的模块名称
     * @param string $ext
     * @return string
     */
    public static function get_mod ($ext = true) {
        return self::$_mod . ($ext ? '_module' : '');
    }

    /**
     * 获取请求的方法名称
     * @param string $ext
     * @return string
     */
    public static function get_act ($ext = true) {
        return self::$_act . ($ext ? '_action' : '');
    }

    /**
     * 获取当前页面的url表达式
     * @return string
     */
    public static function get_current_url () {
        $temp = [
            self::$_mod,
            self::$_act
        ];
        foreach ((array) self::$_request_params as $k => $v) {
            if (!empty($k) && !empty($v)) {
                $temp[] = $k;
                $temp[] = $v;
            }
        }
        if (defined('D_ALIAS')) {
            return (D_ALIAS) . '.' . implode('-', $temp);
        }
        return (APP_NAME == 'default' ? '' : (APP_NAME . ':')) .  implode('-', $temp);
    }

    /**
     * 获取请求参数值
     * @param string $key
     * @param string $scrope
     * @return mixed
     */
    public static function get ($key, $scrope = 'r') {
        return self::_get_request_param($key, $scrope);
    }

    /**
     * 是否存在指定的请求参数
     * @param unknown $key
     * @param string $scrope
     * @return mixed|NULL|array
     */
    public static function exists ($key, $scrope = 'r') {
        return self::_get_request_param($key, $scrope, false);
    }

    /**
     * 获取请求参数
     * @param string $key
     * @param string $scrope
     * @param string $fetch
     * @return mixed
     */
    private static function _get_request_param ($key, $scrope = 'r', $fetch = true) {
        $var = null;
        switch (strtoupper($scrope)) {
            // GET
            case 'G' : $var = &$_GET; break;
            // POST
            case 'P' : $var = &$_POST; break;
            // COOKIE
            case 'C' : $var = &$_COOKIE; break;
            // all
            case '*' :
                foreach (array($_POST, $_COOKIE, self::$_request_params) as $v) {
                    if (isset($v[$key])) {
                        $var = &$v;
                        break;
                    }
                }
                break;
            // REGINX ROUTE PARAM
            default :
                $var = &self::$_request_params;
                break;
        }
        return $fetch ? ($key === null ? $var : (isset($var[$key]) ? $var[$key] : null)) : isset($var[$key]);
    }

    /**
     * 解析命令行参数
     * @throws exception
     * @example index/index || index || index/index/uid=2 || index/index/uid=2/name=abc
     */
    public static function parse_cli () {
        $pathinfo = getenv('request_uri') ?: (isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null);
        if (empty($pathinfo)) {
            $pathinfo = 'index/index';
        }
        putenv("request_uri={$pathinfo}");
        if (!preg_match('/^(?:[0-9a-z\_\-]+)((\/\w+)?(\?.+?)*)?$/i', $pathinfo)) {
            throw new exception(LANG('invalid pathinfo', $pathinfo), exception::NOT_EXISTS);
        }
        list($ma, $qs) = explode('?', $pathinfo);
        $path = explode('/', $ma);
        if (count($path) == 1) {
            $path[] = 'index';
        }
        self::$_mod = array_shift($path);
        self::$_act = array_shift($path);
        parse_str($qs ?: '', self::$_request_params);
    }

    /**
     * 解析url
     * @param array $config
     */
    public static function parse ($config) {
        if (isset($_SERVER['PATH_INFO']) && 
                !empty($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != "/") {
            // compatible for nginx PATH_INFO
            $requrl = substr($_SERVER['PATH_INFO'], 1);
            // 去除后缀
            if (substr($requrl, 0 - strlen($config['suf'])) == $config['suf']) {
                $requrl = substr ($requrl, 0, 0 - strlen($config['suf']));
            }
            if (substr($requrl, - 1) == '/') {
                $requrl = substr($requrl, 0, -1);
            }
            if ($config['ap_sep'] == '?' && !empty($_SERVER['QUERY_STRING'])) {
                $requrl .= $config['ap_sep'] . str_replace($config['suf'], '', $_SERVER['QUERY_STRING']);
            }
        }
        else {
            $requrl = $config['def_mod'] . $config['ma_sep'] . $config['def_act'];
        }
        // 去除后缀
        if (substr($requrl, 0 - strlen($config['suf'])) == $config['suf']) {
            $requrl = substr ($requrl, 0, 0 - strlen($config['suf']));
        }

        // 解析出 module , action 名称
        $ma_str = '';
        if (($pos = stripos($requrl, $config['ap_sep'])) !== false){
            $ma_str = substr($requrl, 0, $pos);
            $requrl = substr($requrl, $pos + strlen($config['ap_sep']));
            // 分隔符相同的情况
            if ($config['ma_sep'] == $config['ap_sep']
                && ($pos = stripos($requrl, $config['ap_sep'])) !== false) {
                $ma_str .= $config['ap_sep'] . substr($requrl, 0, $pos);
                $requrl = substr($requrl, $pos + strlen($config['ap_sep']));
            }
        }
        else if (($pos = stripos($requrl, $config['ma_sep'])) !== false) {
             $ma_str = $requrl;
             $requrl = '';
        }
        else {
            $ma_str = $requrl;
            $requrl = '';
        }

        // 存在 MA 标识
        if (($pos = strpos($ma_str, $config['ma_sep'])) !== false) {
            self::$_mod = substr($ma_str, 0, $pos);
            self::$_act = substr($ma_str, $pos + strlen($config['ma_sep']));
        }
        // 不存在则认作为 _MOD
        else {
            self::$_mod = $ma_str;
            self::$_act = $config['def_act'];
        }
        self::$_mod = self::$_mod ?: $config['def_mod'];
        self::$_act = self::$_act ?: $config['def_act'];

        // request parameters
        if (!empty($requrl)) {
            $vals = explode($config['pg_sep'], $requrl);
            if ($config['pg_sep'] == $config['pp_sep']) {
                for ($i = 0; $i < count($vals); $i +=2) {
                    self::$_request_params[$vals[$i]] = isset($vals[$i + 1]) ? $vals[$i + 1] : null;
                }
            }
            else {
                foreach ((array)$vals as $v) {
                    if (($v = trim($v)) != '') {
                        $tmp = explode($config['pp_sep'], $v);
                        self::$_request_params[$tmp[0]] = isset($tmp[1]) ? $tmp[1] : null;
                    }
                }
            }
        }
    }

    /**
     * 获取路由配置
     * @return array
     */
    public static function get_config () {
        // 路由配置信息
        static $config = null;
        if ($config == null && !IS_CLI) {
            $config = CFG('route') + parse_url(APP_URL);
            $config['path'] = $config['path'] ?: '/';
            $config['app_url'] = APP_URL;
            $config['root_domain'] = sess::get_domain();
        }
        return $config;
    }

    /**
     * 生成 url
     * @return string
     */
    public static function url () {
        $config = self::get_config();
        $input = func_get_args();
        $input = is_array($input[0]) ? $input[0] : $input;
        if (empty($input)) {
            return 'javascript:;';
        }
        $prefix = APP_URL;
        $suffix = $config['suf'];

        if (substr($input[0], -1) == '~') {
            $input[0] = substr($input[0], 0, -1);
            $suffix = '';
        }

        $expr   = explode('-', $input[0]);
        $module = array_shift($expr);

        // 相对路径
        if (substr($module, 0, 1) == '@') {
            $prefix = $config['path'];
            $module = substr($module, 1);
        }
        // admin.system-login
        else if (($pos = strpos($module, '.')) !== false) {
            $host_keys = explode('.', $config['host']);
            if (count($host_keys) > 2) {
                array_shift($host_keys);
            }
            $host   = substr($module, 0, $pos) . "." . join('.', $host_keys);
            $prefix = "{$config['scheme']}://{$host}{$config['path']}";
            $module = substr($module, $pos + 1);
        }
        // admin/user-login
        if (($pos = strpos($module, '/')) !== false) {
            $prefix .= substr($module, 0, $pos + 1);
            $module  = substr($module, $pos + 1);
        }

        $action = empty($expr) ? '' : array_shift($expr);
        $params = [];
        if (!empty($expr)) {
            for ($i = 0; $i < count($expr); $i += 2) {
                if (!isset($expr[$i + 1])) {
                    break;
                }
                $params[] = $expr[$i] . $config['pp_sep'] . $expr[$i + 1];
            }
        }
        if (!empty($params)) {
            $params = $config['ap_sep'] . join($config['pg_sep'], $params);
        }

        $script_file = $config['rewrite'] ? '' : 'index.php/';
        $params  = $params ?: '';

        $url_str = "{$prefix}{$script_file}{$module}" . 
                    (empty($action) ? '' : ($config['ma_sep'] . $action)) . 
                    "{$params}{$suffix}";

        return vsprintf($url_str, array_slice($input, 1));
    }
}