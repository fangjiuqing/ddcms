<?php
namespace re\rgx;

/**
 * @name 用户基本操作
 */
class user_iface extends ubase_iface {

    /**
     * 获取当前登录信息
     * @return [type] [description]
     */
    public function info_action () {
        $this->success('', [
            'admin_id'      => $this->login['admin_id'],
            'admin_nick'    => $this->login['admin_nick'],
            'admin_avatar'  => '',
            'admin_level'   => $this->login['admin_group_id']
        ]);
    }
    
    /**
     * 管理员修改个人密码接口
     * @param $passwd      string 原密码
     * @param $newpasswd   string 新密码
     * @param $renewpasswd string 重复新密码
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
    
}