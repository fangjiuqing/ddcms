<?php
namespace re\rgx;

/**
 * RGX基类
 * $Id: rgx.class.php 181 2017-08-14 03:39:03Z reginx $
 */
class rgx implements \ArrayAccess {

    /**
     * 是否存在
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists ($offset) {
        return property_exists($this, $offset);
    }

    /**
     * 获取
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet ($offset) {
        return $this->$offset;
    }

    /**
     * 设置
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet ($offset, $value) {
        $this->$offset = $value;
    }

    /**
     * 重置
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset ($offset) {
        $this->$offset = null;
    }

    /**
     * Setter
     * @param string $key
     * @param mixed $value
     */
    public function __set ($key, $value) {
        $this->$key = $value;
    }

    /**
     * Getter
     * @param string $key
     * @return mixed
     */
    public function __get ($key) {
        return isset($this->$key) ? $this->$key : null;
    }

    /**
     * 转换为字符串
     * @return string
     */
    public function __toString () {
        return get_class($this);
    }

    /**
     * 调试输出
     * @return array|NULL[]
     */
    public function __debugInfo () {
        return RUN_MODE == 'debug' ? get_object_vars($this) : [
            get_class($this)
        ];
    }

}

/**
 * 获取语言变量
 * {@inheritDoc}
 * @see \re\rgx\lang::get()
 */
function LANG () {
    return lang::get(func_get_args());
}

/**
 * 获取指定类的实例
 * @param string $class
 * @param string $single
 * @param mixed $extra
 * @return \re\rgx\rgx
 */
function OBJ ($class, $single = true, $extra = null) {
    return app::get_instance($class, $single, $extra);
}

/**
 * 设置/获取配置值
 * @param string $key
 * @param mixed $value
 * @param boolean $sync
 * @return mixed
 */
function CFG ($key, $value = null, $sync = false) {
    if ($value !== null) {
        return config::get_instance()->set($key, $value, $sync);
    }
    return config::get_instance()->get($key);
}

/**
 * 设置或获取缓存值
 * @param string $key
 * @param string $value
 * @param number $ttl
 * @return mixed
 */
function CACHE ($key, $value = null, $ttl = null) {
    // value 作为数据来源的callback
    if (is_callable($value)) {
        $ret = app::cache()->get($key);
        if (empty($ret)) {
            $ret = $value();
            app::cache()->set($key, $ret, $ttl);
        }
        return $ret;
    }
    // 有效的值
    else if ($value !== null) {
        return app::cache()->set($key, $value, $ttl);
    }
    return app::cache()->get($key);
}

/**
 * 写入日志
 * @param string $mod
 * @param mixed $msg
 * @param boolean $trace
 * @param mixed $trace_stack
 * {@inheritDoc}
 * @see \re\rgx\app::log()
 */
function LOGS ($mod, $msg, $trace = true, $trace_stack = null) {
    app::log($mod)->write($msg, $trace, $trace_stack);
}

/**
 * 生成 url
 * {@inheritDoc}
 * @see \re\rgx\router::url()
 */
function URL () {
    return router::url(func_get_args());
}

/**
 * var dump
 */
function DUMP () {
    if (!IS_CLI) {
        header("Content-Type: text/html;charset=utf-8");
    }
    call_user_func_array('var_dump', func_get_args());
    exit(0);
}