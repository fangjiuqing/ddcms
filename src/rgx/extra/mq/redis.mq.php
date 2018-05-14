<?php
namespace re\rgx;

/**
 * Redis 消息队列实现类
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
    public function __construct ($conf) {
        if (!class_exists('\Redis', false)) {
            throw new exception(LANG('does not support', '\Redis '), exception::NOT_EXISTS);
        }
        $this->pre = $conf['pre'] ?: $this->pre;

        $this->_redis = new \Redis();
        // connect
        if ($this->_redis->connect($conf['host'], $conf['port'])) {
            $this->_redis->select(intval($conf['db']));
        }
        else {
            throw new exception(LANG('config error', 'Redis'), exception::CONFIG_ERROR);
        }
    }

    /**
     * 入栈
     * @param  [type] $key   [description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function push ($key, $value) {

    }

    /**
     * 出栈
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function pop ($key) {

    }

    /**
     * 删除任务
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function remove ($key) {

    }

    /**
     * 发布
     * @param  [type] $channel [description]
     * @param  [type] $message [description]
     * @return [type]          [description]
     */
    public function publish ($channel, $message) {
        return $this->_redis->publish($this->pre . $channel, 
            is_string($message) ? $message : json_encode($message));
    }

    /**
     * 订阅
     * @param  [type] $channels [description]
     * @param  [type] $callback [description]
     * @return [type]           [description]
     */
    public function subscribe ($channels, $callback) {
        return $this->_redis->subscribe(is_array($channels) ? array_map(function ($channel) {
            return $this->pre . $channel;
        }, $channels) : [$this->pre . $channels],
        $callback);
    }
}

