<?php
namespace re\rgx;

/**
 * 管理基类
 */
class admin_iface extends base_iface {
    
    /**
     * 验证基类
     * @param $mod [模块]
     * @param $data [用户输入信息]
     * @param $login [用户是否登录]
     */
    public function __construct ($mod, $data, $login) {
        parent::__construct($mod, $data, $login);
        $this->check_login();
    }
    
    /**
     * 管理员修改密码接口
     */
    public function passwd_action () {
        $this->verify([
            'passwd'    => [
                'msg'  => '请输入有效的密码',
                'code' => 100,
                'rule' => filter::$rules['passwd'],
            ],
            'newpasswd' => [
                'msg'  => '请输入有效的新密码',
                'code' => 101,
                'rule' => filter::$rules['passwd'],
            ],
        ]);
        if ($this->data['newpasswd'] != $this->data['renewpasswd']) {
            $this->failure('两次密码不一致', '102');
        }
        if (!admin_helper::verify_passwd($this->data['passwd'], $this->login['admin_passwd'], $this->login['admin_salt'])) {
            $this->failure('原密码错误', '103');
        }
        $this->data['admin_passwd'] = md5(md5($this->data['newpasswd']) . $this->login['admin_salt']);
        $this->data['admin_id'] = $this->login['admin_id'];
        if (OBJ('admin_table')->update($this->data)['rows']) {
            $this->success('密码修改成功');
        }
        $this->failure('密码修改失败', '104');
    }
    
}