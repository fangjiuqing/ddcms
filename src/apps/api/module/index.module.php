<?php
namespace com\default_api;
use re\rgx as R;

/**
 * 接口路由类
 * @author reginx
 */
class index_module extends R\module {

    /**
     * 当前请求参数
     * @var array
     */
    public $params = [];

    /**
     * 默认入口
     * @return [type] [description]
     */
    public function index_action () {
        $this->params = json_decode(isset($_POST['raw']) ? $_POST['raw'] : file_get_contents('php://input'), 1);
        if (json_last_error() > 0 || empty($this->params)) {
            $this->ajax_failure('invalid request', 999);
        }

        if (!preg_match('/^\w+(\/\w+?){1,}$/i', $this->params['uri'])) {
            $this->ajax_failure('invalid request', 998);
        }

        // session
        $sess_id = $_SERVER['HTTP_AUTHKEY'];
        if (empty($sess_id) || !preg_match('/^RS\d{1,3}\-[\w\-]+$/i', $sess_id)) {
            $sess_id = null;
        }
        $this->sess('authkey', $sess_id ?: null);

        $login = $this->sess_get('admin_login') ?: null;
        if (!empty($login)) {
            // IP 绑定 RSID
            $last_ip = $this->sess_get('admin_lastip');
            if (empty($last_ip) || $last_ip != ip2long(R\app::get_ip())) {
                $this->sess_del(['admin_login', 'admin_lastip']);
                $this->ajax_failure('请先登录', 900);
            }
        }

        // iface & action
        $uri = explode('/', $this->params['uri']);
        $action = array_pop($uri) . '_action';
        if (empty($uri) && count($uri) > 3) {
            $this->ajax_failure('Resource not found', 996);
        }
        $iface = join('_', $uri) . '_iface';

        $this->log = R\app::log($this->params['uri'], function ($obj) {
            $obj->init($this->params['uri']);
            $obj->write(PHP_EOL . json_encode($this->params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);
        });

        try {
            $obj = R\OBJ($iface, true, [
                'mod'   => $this, 
                'data'  => $this->params['data'] ?: [],
                'login' => $login
            ]);
        }
        catch (\Exception $e) {
            $this->ajax_failure('Resource not found', 995);
        }

        // 判断资源是否存在
        if (!is_callable([$obj, $action])) {
            $this->ajax_failure('Resource not found', 994);
        }

        // 权限验证
        if (!preg_match('/^public.+$/i', $iface)) {
            foreach ((array)R\auth_helper::$rules as $k => $v) {
                R\delegate::register($k, $v);
            }
        }

        $obj->$action();
    }
}
