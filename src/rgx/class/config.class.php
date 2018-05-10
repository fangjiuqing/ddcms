<?php
namespace re\rgx;
/**
 * 配置管理类
 * @author reginx
 */
class config extends rgx {
    
    /**
     * app配置
     * @var array
     */
    private $app = [
        'lang'      => 'zh_cn',
        'timezone'  => 8,
    ];

    /**
     * 模板配置
     * @var array
     */
    private $tpl = [
        'style'     => 'default',
        '404_tpl'   => '404.tpl',
        'msg_tpl'   => 'msg.tpl',
        'ob'        => true,
        'native'    => false,
        'tpl_pre'   => '{',
        'tpl_suf'   => '}',
        'cmod'      => false,
        'charset'   => 'utf-8',
        'allow_php' => false
    ];
    
    /**
     * 缓存配置
     * @var array
     */
    private $cache  = [
        'type'      => 'file',
        'pre'       => 'rgx_',
        'file'      => [],
        'redis'     => [
        ]
    ];

    /**
     * 路由配置
     * @var array
     */
    private $route  = [
        'def_mod'   => 'index',     // 默认 module
        'def_act'   => 'index',     // 默认 action
        'ma_sep'    => '/',         // module action 连接符
        'ap_sep'    => '?',         // action querystring 连接符
        'pg_sep'    => '&',         // kv 组连接符
        'pp_sep'    => '=',         // key value 连接符
        'suf'       => '.html',     // 伪静态后缀
        'rewrite'   => false,       // 是否开启rewrite
        '404_tpl'   => '404.tpl'    // 404 模板页
    ];

    /**
     * 日志配置
     * @var array
     */
    private $log  = [
        'type'      => 'file',
        'file'      => [
            'dev'   => false
        ],
    ];

    /**
     * 数据库配置
     * @var array
     * @example host=127.0.0.1;port=3306;db=rgx;user=root;passwd=;charset=utf8;profile=true
     */
    private $db  = [
        'pre'       => 'pre_',
        'type'      => 'mysql',
        'mysql'     => [
            'default'   => ''
        ],
    ];
    
    /**
     * 会话配置
     * @var array
     */
    private $sess = [
        'type'      => 'php',

        // 默认实现
        'php'       => [
            'ttl'   => 1800
        ],
        // Redis 实现
        'redis'     => [
            'host'  => '127.0.0.1',
            'port'  => 6379,
            'db'    => 5,
            'ttl'   => 1800
        ]
    ];

    /**
     * MQ默认配置
     * @var array
     */
    private $mq = [
        'type'      => 'redis',
        // Redis 实现
        'redis'     => [
            'host'  => '127.0.0.1',
            'port'  => 6379,
            'db'    => 6
        ]
    ];
    
    /**
     * 架构方法
     * @param array $opts
     * @return \re\rgx\config
     */
    protected function __construct ($opts = []) {
        foreach ((array)$opts as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = is_array($v) ? array_merge($this->$k, $v) : $v;
            }
            else {
                $this->$k = $v;
            }
        }
        return $this;
    }
    
    /**
     * 获取实例
     * @param array $opts
     * @return \re\rgx\config
     */
    public static function get_instance ($opts = []) {
        static $instance = null;
        if (empty($instance)) {
            $instance = new config ($opts);
        }
        return $instance;
    }
    
    /**
     * 获取配置项值
     * @param unknown $key
     * @return mixed
     */
    public function get ($key) {
        $ref = $this;
        $paths = explode('.', $key);
        while (!empty($paths)) {
            $k = array_shift($paths);
            if (is_object($ref)) {
                if (!property_exists($ref, $k)) {
                    $ref->$k = [];
                }
                $ref = &$ref->$k;
            }
            else if (is_array($ref)) {
                if (!array_key_exists($k, $ref)) {
                    $ref[$k] = [];
                }
                $ref = &$ref[$k];
            }
        }
        return $ref;
    }

    /**
     * 写入配置值
     * @param unknown $key
     * @param unknown $value
     * @param string $sync
     * 
     * @example
     *      set('abc.efg.0', ['foo' => 1])
     *      set('lang', 'zh_cn')
     */
    public function set ($key, $value, $sync = false) {
        $paths = explode('.', $key);
        $ref = $this;
        while (!empty($paths)) {
            $k = array_shift($paths);
            if (is_object($ref)) {
                if (!property_exists($ref, $k)) {
                    $ref->$k = [];
                }
                $ref = &$ref->$k;
            }
            else if (is_array($ref)) {
                if (!array_key_exists($k, $ref)) {
                    $ref[$k] = [];
                }
                $ref = &$ref[$k];
            }
        }
        $ref = $value;
        $sync && $this->sync();
    }
    
    /**
     * 同步配置信息
     * @param string $source
     */
    public function sync ($source = true) {
        $dist_file = APP_PATH . "config" . DS . "config.php";
        if (!$source) {
            $dist_file = CACHE_PATH . APP_NAME . "_" . APP_ID . DS . "~config.php";
        }
        // write
        $out  = "<?php" . PHP_EOL
                . "/**" . PHP_EOL
                . " * app " . APP_ID ." config file " . PHP_EOL
                . " * @modified by RGX v" . RGX_VER . PHP_EOL
                . " */" . PHP_EOL
                . " return " . var_export(get_object_vars($this), true) . ";";
        // 创建目录
        if (!is_dir(dirname($dist_file))) {
            misc::mkdir(dirname($dist_file));
        }
        // 写入文件
        if (!file_put_contents($dist_file, $out, LOCK_EX)) {
            exit("写入配置文件失败");
        }
    }
}