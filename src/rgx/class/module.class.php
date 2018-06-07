<?php
namespace re\rgx;
/**
 * 应用模块类
 * @author reginx
 */
class module extends rgx {

    /**
     * 会话操作实例
     * @var \re\rgx\sess
     */
    public $_sess = null;

    /**
     * 模板操作实例
     * @var \re\rgx\template
     */
    protected $_tpl = null;

    /**
     * 是否输出性能报告
     * @var boolean
     */
    public $show_profile = false;

    /**
     * 是否为 ajax 请求
     * @var boolean
     */
    public $is_ajax = false;

    /**
     * 架构方法
     * @param array $param
     */
    public function __construct($param = []) {
        $this->_tpl = app::tpl();
        // 设置默认 模板风格目录
        $this->_tpl->style($this->_config['template']);
        $this->assign('_MODULE', router::get_mod(false));
        $this->assign('_ACTION', router::get_act(false));
        $this->is_ajax = $this->has('isajax', '*');
    }

    /**
     * 默认调用
     * @param unknown $method
     * @param array $args
     */
    public function __call ($method, $args = []) {
        if (!method_exists($this, 'defaults')) {
            $this->show404(LANG('not exists', "{$this}::{$method}"));
        }
        $this->defaults($method, $args);
    }

    /**
     * 会话开启
     * @param mixed $sess_name
     * @param mixed $sess_id
     * @param array $opts
     */
    public function sess ($sess_name = null, $sess_id = null, $opts = []) {
       $this->_sess = app::sess($sess_name, $sess_id, $opts);
    }

    /**
     * 获取会话变量
     * @param string $key
     * @return mixed
     */
    public function sess_get ($key) {
        return $this->_sess->get($key);
    }

    /**
     * 设置会话变量
     * @param string $key
     * @param mixed $val
     * @return boolean
     */
    public function sess_set ($key, $val) {
        return $this->_sess->set($key, $val);
    }

    /**
     * 删除会话变量
     * @param unknown $key
     * @return unknown
     */
    public function sess_del ($key) {
        return $this->_sess->del($key);
    }

    /**
     * 销毁会话
     * @return unknown
     */
    public function sess_remove () {
        return $this->_sess->remove();
    }

    /**
     * 获取会话ID
     * @return string
     */
    public function sess_id () {
        return $this->_sess->sess_id();
    }

    /**
     * 获取请求内容 
     * @param string $key
     * @param string $type
     * @return mixed
     */
    public final function get ($key, $type = 'R') {
        return router::get($key, $type);
    }

    /**
     * 判断请求参数中是否存在某项
     * @param string $key
     * @param string $type
     * @return boolean
     */
    public final function has ($key, $type = 'R') {
        return router::exists($key, $type);
    }

    /**
     * 模板变量赋值
     * @param string $key
     * @param mixed $value
     * @return unknown
     */
    public function assign ($key, $value) {
        return $this->_tpl->assign($key, $value);
    }

    /**
     * 获取当前已设置的模板变量值
     * @param string $key
     * @return mixed
     */
    public function get_tpl_var ($key) {
        return $this->_tpl->get($key);
    }

    /**
     * 加载模块语言包
     * @param string $name
     */
    public final function lang ($name = 'zh-cn') {
        lang::load($name);
    }

    /**
     * 禁止客户端缓存当前页
     */
    public final function nocache () {
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", 0) . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
    }

    /**
     * 重定向
     * @param string $url
     * @param string $parse
     * @param string $code
     */
    public final function redirect ($url, $parse = true, $code = '303') {
        header("HTTP/1.1 {$code} See Other");
        header("Location: " . ($parse ? router::url($url) : $url));
        header('X-Powered-By: RGX v' . RGX_VER);
        exit(0);
    }

    /**
     * 请求转发
     * @param string $class
     * @param string $method
     * @param array $extra
     */
    public function forward ($class, $method, &$extra = []) {
        $class = $class . '_module';
        if (empty($extra)) {
            $extra = &$this->conf;
        }
        call_user_func([new $class($extra), $method . '_action']);
    }

    /**
     * ajax 输出
     * @param mixed $data
     * @param string $type
     * @param string $output_header
     */
    public function ajax_out ($data, $type = 'json', $output_header = true) {
        $this->nocache();
        header('X-Powered-By: RGX V' . RGX_VER);
        if ($type == 'json') {
            if ($output_header) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
                    header('Content-Type: text/html; charset=utf-8');
                }
                else {
                    header('Content-Type: application/json; charset=utf-8');
                }
            }
            exit(json_encode($data, 256));
        }
        else {
            header('Content-Type: text/html; charset=utf-8');
            exit($data);
        }
    }

    /**
     * ajax 错误输出
     * @param  [type]  $msg   [description]
     * @param  array   $error [description]
     * @param  integer $code  [description]
     * @return [type]         [description]
     */
    public function ajax_failure ($msg, $code = 1) {
        $this->ajax_out([
            'code'  => $code,
            is_array($msg) ? 'error' : 'msg' => $msg
        ]);
    }

    /**
     * ajax 成功输出
     * @param  [type]  $msg   [description]
     * @param  array   $error [description]
     * @param  integer $code  [description]
     * @return [type]         [description]
     */
    public function ajax_success ($msg, $data = [], $url = null, $code = 0) {
        $this->ajax_out([
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data,
            'url'   => $url
        ]);
    }

    /**
     * 渲染输出模板内容
     * @param string $tplfile
     * @param string $type
     * @param array  $headers
     * @return string
     */
    public function display ($tplfile, $type = 'text/html', $headers = []) {
        if ($this->show_profile) {
            $this->assign('_profile', misc::get_profile());
        }
        return app::tpl()->display($tplfile, $type, $headers);
    }

    /**
     * 获取解析后的模板内容
     * @param string $tplfile
     * @return string
     */
    public function fetch ($tplfile) {
        return app::tpl()->fetch($tplfile, true);
    }

    /**
     * 获取 form token key
     * @param unknown $suf
     * @return string
     */
    public function get_token_key ($suf) {
        return APP_ID . '-' . router::get_mod(false) . '-' . 
                router::get_act(false) . '-' . $suf;
    }

    /**
     * 生成表单token
     * @param string $suf
     * @param number $ttl
     * @return string
     */
    public function form_token ($suf = 'def', $ttl = 3600, $html = 1) {
        if (empty($this->_sess)) {
            $this->sess();
        }
        $key = $this->get_token_key($suf);
        $token = md5(REQUEST_TIME . misc::randstr(8));
        $this->sess_set($key, $token, $ttl);
        return $html ? "<input id=\"RGX-FORM-TOKEN-{$suf}\" type=\"hidden\" name=\"{$key}\" value=\"{$token}\" />" :
                        $token;
    }

    /**
     * 验证 token
     * @param unknown $suf
     * @return boolean
     */
    public function verify_token ($suf = 'def') {
        $ret = false;
        $key = $this->get_token_key($suf);
        $val = $this->get($key, '*');
        if (empty($this->_sess)) {
            $this->sess();
        }
        return $val == $this->sess_get($key);
    }

    /**
     * 删除表单token
     * @param string $suf
     */
    public function rmtoken ($suf = 'def') {
        if (empty($this->_sess)) {
            $this->sess();
        }
        $this->sess_del($this->get_token_key($suf));
    }

    /**
     * 显示404页面
     * @param string $msg
     */
    public function show_404 ($msg = '404 not found') {
        header('X-Powered-By: RGX v' . RGX_VER);
        if (IS_CLI) {
            app::cli_msg($msg);
        }
        $this->assign('msg', $msg ?: LANG('404 not found'));
        $this->display(CFG('tpl.404_tpl'), 'text/html', ['HTTP/1.1 404 Not Found']);
    }

    /**
     * 显示提示消息
     * @param unknown $msg
     * @param unknown $url
     * @param string $auto_jump
     * @param number $ttl
     */
    public function show_msg ($msg, $url = null, $auto_jump = false, $ttl = 2) {
        if (IS_CLI) {
            app::cli_msg($msg);
        }
        $this->assign('msg', $msg);
        $this->assign('url', $url);
        $this->assign('ttl', $ttl);
        $this->assign('auto_jump', $auto_jump);
        $this->display(CFG('tpl.msg_tpl'));
    }
}