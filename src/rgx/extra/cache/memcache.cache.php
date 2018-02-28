<?php
namespace re\rgx;
/**
 * Memcache 缓存驱动类
 * @author reginx
 */
class mem_cache extends cache {

    /**
     * 当前连接的 Server ID
     * @var unknown
     */
    private $_serverid = null;

    /**
     * 配置信息
     * @var array
     */
    private $_conf = [];

    /**
     * 前缀
     * @var string
     */
    private $_pre = 'pre_';

    /**
     * 当前Memcache 对象
     * @var unknown
     */
    private $_mobj = null;

    /**
     * 架构方法
     * @param array $opts
     * @throws exception
     */
    public function __construct ($opts) {
        $this->_conf = &$opts;
        $this->_serverid = mt_rand(0, count($this->_conf) - 1);
        $this->_serv = $this->_conf[$this->_serverid];
        $this->_pre  = isset($this->_conf[$this->_serverid]['pre']) ? 
                        $this->_conf[$this->_serverid]['pre'] : $this->_pre;
        if (!class_exists('\Memcache', false)) {
            throw new exception(LANG('does not support', '\Memcache '), 
                exception::NOT_EXISTS);
        }
        if (empty($this->_mobj)) {
            $this->_mobj = new \Memcache();
        }
        if (count($this->_conf) == 1) {
            // 单台 
            if (!$this->_mobj->connect($this->_serv['host'], $this->_serv['port'])) {
                throw new exception(LANG('config error', '\Memcache'), 
                    exception::CONFIG_ERROR);
            }
        }
        else {
            // 集群
            foreach ($this->_conf as $v) {
                $p = (!isset($v['p']) || $v['p']) ? true : false;
                $w = intval(isset($v['w']) ? $v['w'] : (100 / count($this->_conf)));
                $this->_mobj->addServer($v["host"], $v["port"], $p, $w);
            }
        }
    }

    /**
     * 写入
     * {@inheritDoc}
     * @see \re\rgx\cache::set()
     */
    public function set ($key, $val, $ttl = 0) {
        $this->count('w');
        // 默认不使用 zlib压缩
        $this->_mobj->set($this->_getkey($key), $val, 0, intval($ttl));
    }

    /**
     * 获取
     * {@inheritDoc}
     * @see \re\rgx\cache::get()
     */
    public function get ($key) {
        $this->count('r');
        return $this->_mobj->get($this->_getkey($key));
    }

    /**
     * 清除全部缓存数据
     * {@inheritDoc}
     * @see \re\rgx\cache::flush()
     */
    public function flush ($group = null) {
        $this->_mobj->flush();
    }

    /**
     * 删除单个缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::del()
     */
    public function del ($key) {
        return $this->_mobj->delete($this->_getkey($key));
    }

    /**
     * 运行状态统计
     * {@inheritDoc}
     * @see \re\rgx\cache::stat()
     */
    public function stat () {
        $stat = $this->_mobj->getStats();
        $ret   = [];
        $ret[] = ['命中率', sprintf('%.2f', $stat["get_hits"] / ($stat["get_misses"] + $stat["get_hits"]))];
        $ret[] = ['丢失率', sprintf('%.2f', $stat["get_misses"] / ($stat["get_misses"] + $stat["get_hits"]))];
        $ret[] = ['已读数', sprintf('%.2f K', $stat["bytes_read"] / 1024)];
        $ret[] = ['已写数', sprintf('%.2f K', $stat["bytes_written"] / 1024)];
        $ret[] = ['总内存', sprintf('%.2f M', $stat["limit_maxbytes"] / 1024 / 1024)];
        return $ret;
    }

    /**
     * 获取 key
     * @param string $str
     * @return string
     */
    private function _getkey ($str) {
        return $this->_pre . $str;
    }

    /**
     * 析构函数
     */
    public function __destruct () {
        if ($this->_mobj) {
            $this->_mobj->close();
        }
    }
}