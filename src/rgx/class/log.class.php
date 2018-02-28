<?php
namespace re\rgx;
/**
 * 日志操作抽象类
 * @author reginx
 */
abstract class log extends rgx {

    /**
     * 配置信息
     * @var array
     */
    protected $config = null;
    
    /**
     * 写入日志
     * @param mixed   $content
     * @param boolean $trace
     * @param mixed   $trace_stack
     */
    abstract protected function write ($content, $trace = false, $trace_stack = null);

    /**
     * 持久化
     * @param string $mod
     */
    abstract protected function flush ($mod = null);

    /**
     * 初始化
     * @param string $mod
     */
    abstract protected function init ($mod);

    /**
     * 获取日志操作实例
     * @param array $config
     * @param mixed $callback
     * @throws exception
     * @return \re\rgx\log
     */
    public static function get_instance ($config, $callback = null) {
        static $logobj = null;
        if (empty($logobj)) {
            $type = CFG('log.type') ?: 'file';
            if (RUN_MODE == 'debug') {
                $file = RGX_PATH . 'extra/log/' . $type . '.log.php';
                if (!is_file($file)) {
                    throw new exception(LANG('driver file not found', $type . '_log'), exception::NOT_EXISTS);
                }
                include ($file);
            }
            $class = __NAMESPACE__ . "\\" . $type . '_log';
            $logobj = new $class($config[$config['type']]);
            if (is_callable($callback)) {
                $callback($logobj);
            }
        }
        return $logobj;
    }
}