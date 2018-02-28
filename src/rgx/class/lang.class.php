<?php
namespace re\rgx;
/**
 * 语言包类
 * @author reginx
 */
class lang extends rgx {

    /**
     * 默认语言包
     * @var array
     */
    private static $lang  = [
        'zh_cn'     => [
            '404 not found'                 => '该页面未找到',
            'auto load not allowed'         => '「 %s 」文件不允许自动加载',
            'config error'                  => '「 %s 」配置信息错误',
            'directory not available'       => '目录「 %s 」不存在或无权限访问',
            'does not support'              => '「 %s 」不支持',
            'driver file not found'         => '驱动文件不存在「 %s 」',
            'duplicate entry not allow'     => '唯一性检测失败「 %s 」,该记录已经存在了',
            'error has been recorded'       => '错误已经被记录',
            'failed to create dir'          => '创建目录「 %s 」失败了',
            'failed to create file'         => '创建文件「 %s 」失败了',
            'field not allow null'          => '「 %s 」字段为必填字段',
            'field values cannot be an empty string'    => '「 %s 」字段值不能为空字符串',
            'field values is too large'     => '「 %s 」字段值太大, 最大值为%s',
            'field values is too long'      => '「 %s 」字段值太长, 最大长度为%s',
            'field values is too small'     => '「 %s 」字段值太小, 最小值为%s',
            'file not exists'               => '文件「 %s 」不存在',
            'get help'                      => '获取帮助',
            'invalid cache key'             => '无效的缓存键名',
            'invalid callback'              => '无效的回调函数',
            'invalid data type'             => '「 %s 」无效的数据类型',
            'invalid field values'          => '「 %s 」字段值无效「 %s 」',
            'invalid format'                => '< %s > 无效的格式化参数',
            'invalid pathinfo'              => '「 %s 」无效的请求路径',
            'invalid RegEx'                 => '「 %s 」无效的正则表达式',
            'invalid template tag'          => '「 %s 」无效的模板变量处理标签',
            'invalid thumbnail size'        => '「 %s 」无效的缩略尺寸',
            'invalid delegate register key' => '「 %s 」无效的代理注册名',
            'invalid name of procedure or function'     => '「 %s 」无效的存储过程或函数名',
            'local language not exists'     => '对应的语言项目不存在「 %s 」',
            'no data'                       => '「 %s 」没有数据',
            'not exists'                    => '「 %s 」不存在',
            'service connection failed'     => '连接「 %s 」服务失败 </li><li> %s',
            'sql query fails'               => '查询失败 「 %s 」</li><li>查询语句 「 %s 」',
            'undefined constant'            => '未定义的模板常量「 %s 」',
            'unique index validate'         => '%s 唯一键约束自动验证',
            'primary key does not exist'    => '%s 唯一性自增主键不存在',
        ]
    ];
    
    /**
     * 默认语言地区
     * @var string
     */
    private static $local = 'zh_cn';
    
    /**
     * 设置地区
     * @param string $local
     */
    public static function set_local ($local = null) {
        self::$local = $local ?: self::$local;
    }

    /**
     * 获取
     */
    public static function get () {
        $args = func_get_args();
        if (!empty($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }
        if (empty($args) || !isset(self::$lang[self::$local][$args[0]])) {
            //throw new exception(self::get('local language not exists', $args[0]));
            return $args[0];
        }
        $key    = array_shift($args);
        $source = self::$lang[self::$local][$key];
        $len = sizeof(preg_split('/\%\w/i', $source));
        if ($len > 0) {
            if ($len - 1 != count($args)) {
                throw new exception(self::get('invalid format', $source));
            }
            $source = vsprintf($source, $args);
        }
        return $source;
    }

    /**
     * 获取所有语言变量
     * @return array
     */
    public static function get_all () {
        return self::$lang;
    }

    /**
     * 设置
     * @param string $local
     * @param array $lang
     */
    public static function set ($local = 'zh_cn', $lang = []) {
        if (!isset(self::$lang[$local])) {
            self::$lang[$local] = [];
        }
        self::$lang[$local] += $lang;
    }

    /**
     * 批量设置
     * @param array $lang
     */
    public static function set_all ($lang = []) {
        foreach ($lang as $k => $v) {
            if (!isset(self::$lang[$k])) {
                self::$lang[$k] = [];
            }
            self::$lang[$k] = array_merge(self::$lang[$k], $v);
        }
    }
    
    /**
     * 加载语言包
     * @param string $name
     */
    public static function load ($name) {
        $file = LANG_PATH . "{$name}.lang.php";
        if (is_file($file) || file_exists($file)) {
            self::set_all(include($file));
        }
    }
}