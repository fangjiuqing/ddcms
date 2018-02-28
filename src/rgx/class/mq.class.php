<?php
namespace re\rgx;

/**
 * 消息队列抽象类
 * @author reginx
 */
abstract class mq extends rgx {

    /**
     * 获取队列操作对象
     * @param  array  $conf  [description]
     * @param  array  $extra [description]
     * @return [type]        [description]
     */
    public static final function get_instance($conf = [], $extra = []) {
        static $sobj = null;
        if (empty($sobj)) {
            $conf = $conf ?: CFG('mq');
            $type = $conf['type'] ? $conf['type'] : 'php';
            if (RUN_MODE == 'debug') {
                $file = RGX_PATH . 'extra/mq/' . $type . '.mq.php';
                if (!is_file($file)) {
                    throw new exception(LANG('driver file not found', "{$conf['type']}_mq"), exception::NOT_EXISTS);
                }
                include ($file);
            }
            $class = __NAMESPACE__ . "\\" . $type . '_mq';
            $sobj = new $class($conf[$conf['type']], $extra);
        }
        return $sobj;
    }

    /**
     * 入栈
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    abstract public function push ($key, $value);

    /**
     * 出栈
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    abstract public function pop ($key);

    /**
     * 删除任务
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    abstract public function remove ($key);
}