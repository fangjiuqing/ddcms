<?php
namespace re\rgx;
/**
 * APC 缓存驱动类
 * @author reginx
 */
class apc_cache extends cache {

    /**
     * 前缀
     * @var string
     */
    private $_pre = 'pre_';

    /**
     * 架构方法
     * @param array $conf
     * @throws exception
     */
    public function __construct ($conf = []) {
        $this->_pre = isset($conf['pre']) ? $conf['pre'] : 'pre_';
        if (!function_exists('apc_fetch')) {
            throw new exception(LANG('does not support', 'APC '), exception::NOT_EXISTS);
        }
    }

    /**
     * 获取值
     * {@inheritDoc}
     * @see \re\rgx\cache::get()
     */
    public function get ($key) {
        $this->count('r');
        return apc_fetch(strtolower($this->_pre . $key));
    }

    /**
     * 写入缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::set()
     */
    public function set ($key, $val, $ttl = null) {
        $this->count('w');
        return apc_store(strtolower($this->_pre . $key) , $val , $ttl ? $ttl : 86400);
    }

    /**
     * 清除缓存数据
     * {@inheritDoc}
     * @see \re\rgx\cache::flush()
     */
    public function flush ($group = null) {
        // 清除指定前缀缓存
        if (!empty($group)) {
            $list = apc_cache_info('user');
            if (!empty($list['cache_list'])) {
                $key = $this->_pre . $group;
                $len = strlen($key);
                foreach ((array)$list['cache_list'] as $v) {
                    if (substr($v['info'], 0, $len) == $key) {
                        apc_delete($v['info']);
                    }
                }
            }
        }
        // 清除全部
        else {
            apc_clear_cache('user');
        }
    }

    /**
     *  删除单个缓存
     * {@inheritDoc}
     * @see \re\rgx\cache::del()
     */
    public function del ($key) {
        return apc_delete(strtolower($this->_pre . $key));
    }

    /**
     * 运行状态统计
     * {@inheritDoc}
     * @see \re\rgx\cache::stat()
     */
    public function stat(){
        $ret  = [];
        $info = apc_cache_info('user');
        $ret[] = [LANG('cache type'), 'APC'];
        $ret[] = [LANG('cache entries'), $info['num_entries']];
        $ret[] = [LANG('cache size'), sprintf('%.2f K' , $info['mem_size']  / 1024)];
        $ret[] = [LANG('uptime'), $info['start_time']];
        return $ret;
    }

}