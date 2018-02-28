<?php
namespace re\rgx;
/**
 * Redis 缓存驱动类
 * @author reginx
 */
class redis_cache extends cache {

    /**
     * 前缀
     * @var string
     */
    private $_pre = 'rex_';

    /**
     * Redis 对象
     * @var unknown
     */
    private $_redis = null;

    /**
     * 架构方法
     * @param array $conf
     * @throws exception
     */
    public function __construct ($conf = []) {
        $this->_pre = isset($GLOBALS['_RC']['cache']['pre']) ? 
                        $GLOBALS['_RC']['cache']['pre'] : 'rex_';
        if (!class_exists('Redis', false)) {
            throw new exception(LANG('does not support', '\Redis '), exception::NOT_EXISTS);
        }
        $this->_redis = new \Redis();
        // connect
        if ($this->_redis->connect($conf[0]['host'], $conf[0]['port'])) {
            $this->_redis->select(intval($conf[0]['db']));
        }
        else {
            throw new exception(LANG('config error', 'Redis'), exception::CONFIG_ERROR);
        }
    }

    /**
     * 获取项目键
     * @param string $key
     * @return string
     */
    private function _getkey ($key) {
        return $this->_pre . $key;
    }

    /**
     * 统计
     * {@inheritDoc}
     * @see \re\rgx\cache::stat()
     */
    public function stat () {
        $ret   = $stat  = [];
        $info  = $this->_redis->info();
        $ret[] = [LANG('cache type'), 'Redis v' . $info['redis_version']];
        $ret[] = [LANG('uptime'), $info['uptime_in_days'] . ' Days'];
        $ret[] = [LANG('cache entries'), $this->_redis->dbSize()];
        $ret[] = ['命中总数', $info['keyspace_hits']];
        $ret[] = ['丢失总数', $info['keyspace_misses']];
        $ret[] = ['执行总数', $info['total_commands_processed']];
        $ret[] = [LANG('queries per second avg'), $info['instantaneous_ops_per_sec']];
        $ret[] = [LANG('number of connections'), $info['connected_clients']];
        $ret[] = ['持久化时间', date('Y-m-d H:i:s', $info['rdb_last_save_time'])];
        return $ret;
    }

    /**
     * 获取缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::get()
     */
    public function get($key) {
        $this->count('r');
        $ret = $this->_redis->get($this->_getkey($key));
        if ($ret !== false && !empty($ret)) {
            if (in_array(substr($ret, 0, 2), array('a:', 's:', 'i:', 'd:', 'N;', 'b:', 'O:'))
                    && in_array(substr($ret, -1), array(';', '}'))) {
                $ret = unserialize($ret);
            }
        }
        return $ret;
    }

    /**
     * 设置缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::set()
     */
    public function set ($key, $value, $ttl = 0) {
        $this->count('w');
        if (is_array($value)) {
            $value = serialize($value);
        }
        $key = $this->_getkey($key);
        return $this->_redis->set($key, $value, $ttl > 0 ? ['ex' => $ttl] : []);
    }

    /**
     * 删除指定缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::del()
     */
    public function del ($key) {
        return $this->_redis->del($this->_getkey($key));
    }

    /**
     * 批量清除缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::flush()
     */
    public function flush ($group = null) {
        return $this->_redis->flushDB();
    }

    /**
     * 析构函数
     */
    public function __destruct () {
        if ($this->_redis) {
            $this->_redis->close();
        }
    }
}