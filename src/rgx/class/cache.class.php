<?php
namespace re\rgx;
/**
 * 缓存操作抽象类
 * @author reginx
 */
abstract class cache extends rgx {

    /**
     * 操作统计
     * @var array
     */
    protected $_stat = array(
        'write' => 0,
        'read'  => 0
    );
    
    /**
     * 默认配置
     * @var array
     */
    private static $_conf = [
        'type'  => 'file',
        'pre'   => 'RGX_',
        'file'  => []
    ];

    /**
     * 实例列表
     * @var array
     */
    private static $_obj = [];

    /**
     * 统计
     * @param string $type
     */
    public final function count ($type = 'w') {
        $this->_stat[$type == 'w' ? 'write' : 'read'] ++;
    }
    
    /**
     * 架构方法
     * @param array $config
     * @param array $extra
     * @throws exception
     * @return \re\rgx\cache
     */
    public static final function get_instance ($config = [], $extra = []) {
        $extra = $extra ?: ['name' => APP_NAME, 'id' => APP_ID];
        $key   = join('_', $extra);
        if (!isset(self::$_obj[$key])) {
            $config = array_merge(self::$_conf, $config);
            // 缓存读取统计
            $GLOBALS['_STAT']['cache_reads']  = 0;
            // 缓存写入统计
            $GLOBALS['_STAT']['cache_writes'] = 0;

            $class = $config['type'] . '_cache';
            $class = __NAMESPACE__ . "\\" . $class;
            
            if (!class_exists($class, false)) {
                if (RUN_MODE == 'debug') {
                    $file = RGX_PATH . 'extra/cache/' . $config['type'] . '.cache.php';
                    if (!is_file($file)) {
                        throw new exception(LANG('driver file not found', $class), exception::NOT_EXISTS);
                    }
                    include($file);
                }
            }
            self::$_obj[$key] = new $class($config[$config['type']], $extra);
        }

        return self::$_obj[$key];
    }

    /**
     * 缓存数据统计
     */
    abstract public function stat ();

    /**
     * 获取缓存
     * @param string $key
     */
    abstract public function get ($key);

    /**
     * 写入缓存
     * @param string $key
     * @param mixed $value
     * @param number $ttl
     */
    abstract public function set ($key, $value, $ttl = 0);

    /**
     * 删除缓存项
     * @param string $key
     */
    abstract public function del ($key);

    /**
     * 清空
     * @param mixed $group
     */
    abstract public function flush ($group = null);
}
