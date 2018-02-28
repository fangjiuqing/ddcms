<?php
namespace re\rgx;

/**
 * 代理类
 * @author reginx
 */
class delegate {

    /**
     * 前置操作
     */
    const BEFORE = 0;

    /**
     * 后置操作
     */
    const AFTER  = 1;

    /**
     * 执行时机
     * @var [type]
     */
    public static $timing = [
        'before'    => 0,
        'after'     => 1
    ];

    /**
     * 被委托的对象
     * @var null
     */
    private $instance = null;

    /**
     * 实例代码
     * @var string
     */
    private $instance_code = '';

    /**
     * 用户委托配置
     * @var array
     */
    private static $directive = [];

    /**
     * 系统委托配置
     * @var array
     */
    private static $system_directive = [];

    /**
     * 架构方法
     * @param [type] $obj  [description]
     * @param array  $args [description]
     */
    public function __construct ($code, $obj) {
        $this->instance = $obj;
        $this->instance_code = $code;
    }

    /**
     * 注册指令
     * @param  [type]  $key        [description]
     * @param  [type]  $callback   [description]
     * @param  boolean $limit      [description]
     * @return [type]              [description]
     */
    public static function register ($key, $callback, $limit = false) {
        list($skey, $timing) = explode('@', $key, 2);
        if (isset(self::$timing[$timing])) {
            self::$directive[self::$timing[$timing]][$skey] = [
                'callback'      => $callback,
                'limit'         => $limit
            ];
        }
        else {
            throw new exception(LANG('invalid delegate register key', $key), exception::INVALID);
        }
    }

    /**
     * 系统指令指令
     * @param  [type]  $key        [description]
     * @param  [type]  $callback   [description]
     * @param  boolean $limit      [description]
     * @return [type]              [description]
     */
    public static function system_register ($key, $callback, $limit = false) {
        list($skey, $timing) = explode('@', $key, 2);
        if (isset(self::$timing[$timing])) {
            self::$system_directive[self::$timing[$timing]][$skey] = [
                'callback'      => $callback,
                'limit'         => $limit
            ];
        }
        else {
            throw new exception(LANG('invalid delegate register key', $key), exception::INVALID);
        }
    }

    /**
     * 取消注册
     * @param  [type] $key      [description]
     * @param  [type] $callback [description]
     * @return [type]           [description]
     */
    public static function unregister ($key) {
        list($key, $timing) = explode('@', $key, 2);
        $timing = isset(self::$timing[$timing]) ? self::$timing[$timing] : 0;
        if (isset(self::$directive[$timing][$key])) {
            unset(self::$directive[$timing][$key]);
        }
    }

    /**
     * 取消注册
     * @param  [type] $key      [description]
     * @param  [type] $callback [description]
     * @return [type]           [description]
     */
    public static function system_unregister ($key) {
        list($key, $timing) = explode('@', $key, 2);
        $timing = isset(self::$timing[$timing]) ? self::$timing[$timing] : 0;
        if (isset(self::$system_directive[$timing][$key])) {
            unset(self::$system_directive[$timing][$key]);
        }
    }

    /**
     * 调用执行
     * @param  [type] $method [description]
     * @param  array  $args   [description]
     * @return [type]         [description]
     */
    public function __call ($method, $args = []) {
        $key = "{$this->instance_code}::{$method}";

        // before
        $before = self::adapter_action($key, self::BEFORE);
        if (!empty($before)) {
            $args = call_user_func_array($before['callback'], $args) ?: $args;
            // 单次执行处理
            if ($before['limit']) {
                unset(self::$directive[self::BEFORE][$before['key']]);
            }
        }

        $ret = call_user_func_array([$this->instance, $method], $args);

        // after
        $after = self::adapter_action($key, self::AFTER);
        if (!empty($after)) {
            $ret = call_user_func_array($after['callback'], [$ret]) ?: $ret;
            // 单次执行处理
            if ($after['limit']) {
                unset(self::$directive[self::AFTER][$after['key']]);
            }
        }

        return $ret === $this->instance ? $this : $ret;
    }

    /**
     * 获取匹配动作
     * @param  [type] $code   [description]
     * @param  string $timing [description]
     * @return [type]         [description]
     */
    public static function adapter_action ($code, $timing = self::BEFORE) {
        $ret = null;
        // 全字匹配
        foreach ((array)self::$directive[$timing] as $k => $v) {
            if ($k === $code) {
                $v['key'] = $k;
                $ret = $v;
                break;
            }
        }
        // *table
        if (empty($ret)) {
            foreach ((array)self::$directive[$timing] as $k => $v) {
                if ($k != '*' && preg_match("/^" . str_replace('\\*', '\w*', preg_quote($k)) . "$/i", $code)) {
                    $v['key'] = $k;
                    $ret = $v;
                    break;
                }
            }
        }
        // *
        if (empty($ret)) {
            foreach ((array)self::$directive[$timing] as $k => $v) {
                if ($k == '*') {
                    $v['key'] = $k;
                    $ret = $v;
                    break;
                }
            }
        }

        return $ret;
    }

    /**
     * 主动触发
     * @param  [type] $key    [description]
     * @param  string $timing [description]
     * @param  array  $args   [description]
     * @return [type]         [description]
     */
    public static function trigger ($key, $timing= 0, ...$args) {
        $action = isset(self::$system_directive[$timing][$key]) ? self::$system_directive[$timing][$key] : null;
        if (!empty($action)) {
            $args = call_user_func_array($action['callback'], $args) ?: $args;
            // 单次执行处理
            if ($acton['limit']) {
                unset(self::$system_directive[$timing][$key]);
            }
        }
        return $args ?: null;
    }

    /**
     * Setter
     * @param string $key
     * @param mixed $value
     */
    public function __set ($key, $value) {
        $this->instance->{$key} = $value;
    }

    /**
     * 是否存在某属性
     * @param  [type]  $key [description]
     * @return boolean      [description]
     */
    public function __isset ($key) {
        return isset($this->instance->{$key});
    }

    /**
     * 释放属性
     * @param [type] $key [description]
     */
    public function __unset ($key) {
        unset($this->instance->{$key});
    }

    /**
     * Getter
     * @param string $key
     * @return mixed
     */
    public function __get ($key) {
        return property_exists($this->instance, $key) ? $this->instance->{$key} : null;
    }

    /**
     * 转换为字符串
     * @return string
     */
    public function __toString () {
        return "delegate(" . get_class($this->instance) . ")";
    }

    /**
     * 调试输出
     * @return array|NULL[]
     */
    public function __debugInfo () {
        return RUN_MODE == 'debug' ? get_object_vars($this->instance) : [
            'instance'          => "object(" . get_class($this->instance) . ")",
            'instance_code'     => $this->instance_code
        ];
    }
}