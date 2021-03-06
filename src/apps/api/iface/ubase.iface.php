<?php
namespace re\rgx;

/**
 * 管理基类
 */
class ubase_iface extends base_iface {
    
    /**
     * 验证基类
     * @param $mod   [模块]
     * @param $data  [用户输入信息]
     * @param $login [用户是否登录]
     */
    public function __construct ($params = []) {
        parent::__construct($params);
        $this->check_login();
    }
}