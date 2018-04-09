<?php
namespace re\rgx;

/**
 * 管理基类
 */
class admin_iface extends base_iface {
    
    /**
     * 验证基类
     * @param $mod   [模块]
     * @param $data  [用户输入信息]
     * @param $login [用户是否登录]
     */
    public function __construct ($mod, $data, $login) {
        parent::__construct($mod, $data, $login);
        $this->check_login();
    }
    
    /**
     * 管理员修改个人密码接口
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
        if ($this->data['passwd'] == $this->data['newpasswd']) {
            $this->failure('请输入正确的新密码', '102');
        }
        if ($this->data['newpasswd'] != $this->data['renewpasswd']) {
            $this->failure('两次密码不一致', '103');
        }
        if (!admin_helper::verify_passwd($this->data['passwd'], $this->login['admin_passwd'], $this->login['admin_salt'])) {
            $this->failure('原密码错误', '104');
        }
        $this->data['admin_passwd'] = md5(md5($this->data['newpasswd']) . $this->login['admin_salt']);
        $this->data['admin_id'] = $this->login['admin_id'];
        if (OBJ('admin_table')->update($this->data)['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'admin/passwd', '2',
                '修改管理员密码成功[' . $this->login['admin_id'] . '@]');
            $this->success('密码修改成功');
        }
        admin_helper::add_log($this->login['admin_id'], 'admin/passwd', '2',
            '修改管理员密码失败[' . $this->login['admin_id'] . '@]');
        $this->failure('密码修改失败', '105');
    }
    
    /**
     * 管理员账号列表
     */
    public function list_action () {
        $tab = OBJ('admin_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $arts = $tab->order('admin_account')->get_all();
        $rets = [];
        foreach ((array)$arts as $k => $v) {
            unset($v['admin_passwd']);
            unset($v['admin_salt']);
            $rets[$k] = $v;
        }
        $this->success('操作成功', [
            'list'   => array_values($rets),
            'paging' => $paging->to_array(),
        ]);
    }
    
}