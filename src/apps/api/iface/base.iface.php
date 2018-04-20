<?php
namespace re\rgx;

/**
 * 接口实现基类
 * @author reginx
 */
class base_iface extends rgx {

    /**
     * 请求参数
     * @var array
     */
    public $data = [];

    /**
     * 模块实例
     * @var null
     */
    public $mod  = null;

    /**
     * 日志实例
     * @var null
     */
    public $log  = null;

    /**
     * 登录用户
     * @var null
     */
    public $login = null;

    /**
     * 操作类型
     * @var string
     */
    public $action = 'post';

    /**
     * 架构函数
     * @param [type] $mod   [description]
     * @param [type] $data  [description]
     * @param [type] $login [description]
     */
    public function __construct ($params = []) {
        $this->mod = $params['mod'];
        $this->log = $params['mod']->log;
        $this->data = $params['data'];
        $this->login = $params['login'];
        if (isset($this->data['__action__'])) {
            $this->action = $this->data['__action__'];
        }
    }

    /**
     * 检测登录状态
     * @return [type] [description]
     */
    public function check_login () {
        if (empty($this->login)) {
            $this->failure('请先登录', 100);
        }
    }

    /**
     * 设置当前登录
     * @param [type] $user [description]
     */
    public function set_login ($user) {
        $this->mod->sess_set('admin_login', $user);
        $this->mod->sess_set('admin_lastip', ip2long(app::get_ip()));
        admin_helper::add_log($user['admin_id'], 'user/login', 1, '登录成功');
    }

    /**
     * [注销登录]
     * @return [type] [description]
     */
    public function del_login () {
        if ( $this->mod->sess_set('admin_login', []) ) {
            admin_helper::add_log($user['admin_id'], 'user/logout', 1, '注销成功');
            return true;
        }
        return false;
    }

    /**
     * 数据验证
     * @param  [type] $rules [description]
     * @return [type]        [description]
     */
    public function verify ($rules, $ref = null) {
        foreach ($rules as $k => $rule) {
            $result = true;
            $value  = ($ref ? $ref[$k] : $this->data[$k]) ?: null;
            //  跳过可为空的字段
            if ($rule['allow_empty'] && ($value == '' || $value == null)) {
                continue;
            }
            if (is_callable($rule['rule'])) {
                $result = $rule['rule']($value);
            }
            else if (is_array($rule['rule'])) {
                $result = call_user_func_array($rule['rule'], [$value]);
            }
            else {
                $result = preg_match($rule['rule'], $value);
            }

            if (!$result) {
                $this->failure($rule['msg'], $rule['code'], ['via' => $k]);
            }
        }
    }

    /**
     * 成功输出
     * @param  [type]  $msg  [description]
     * @param  [type]  $data [description]
     * @param  integer $code [description]
     * @return [type]        [description]
     */
    public function success ($msg, $data = [], $code = 0) {
        $this->mod->ajax_out([
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data ?: [],
            'access_token'  => $this->mod->sess_id()
        ]);
    }

    /**
     * 输出错误消息
     * @param  [type]  $msg  [description]
     * @param  integer $code [description]
     * @return [type]        [description]
     */
    public function failure ($msg, $code = 100, $data = []) {
        $this->mod->ajax_out([
            'code'  => $code,
            is_array($msg) ? 'error' : 'msg' => $msg,
            'data'  => $data
        ]);
    }
}