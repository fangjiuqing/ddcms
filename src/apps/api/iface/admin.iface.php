<?php
namespace re\rgx;

/**
 * 管理基类
 */
class admin_iface extends ubase_iface {
    
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
        $group = [];
        $arts = $tab->map(function ($row) use (&$group) {
            $group[$row['admin_group_id']] = 1;
            return $row;
        })->order('admin_account')->get_all();
        $group_source = OBJ('admin_group_table')->akey('pag_id')->get_all([
            'pag_id' => array_keys($group ?: [0]),
        ]);
        $rets = [];
        foreach ((array)$arts as $k => $v) {
            unset($v['admin_passwd']);
            unset($v['admin_salt']);
            $v['admin_group_name'] = isset($group_source[$v['admin_group_id']]) ?
                $group_source[$v['admin_group_id']]['pag_name'] : '';
            $rets[$k] = $v;
        }
        
        $this->success('操作成功', [
            'list'   => array_values($rets),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * 删除管理员账号
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('admin_table');
        if ($tab->get($id)) {
            if ($tab->delete(['admin_id' => $id])['rows'] === 1) {
                admin_helper::add_log($this->login['admin_id'], 'admin/del', '3', '删除管理员账号');
                $this->success('操作成功');
            }
        }
        $this->failure('操作失败');
    }
    
    /**
     * 管理员账号信息获取
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $group_source = OBJ('admin_group_table')->get_all();
        if ($ret = OBJ('admin_table')->get($id)) {
            unset($ret['admin_passwd']);
            unset($ret['admin_salt']);
            $ret['group'] = $group_source;
            $this->success('操作成功', $ret);
        }
        $this->failure('操作失败');
    }
    
    /**
     * 管理员账号新增
     */
    public function save_action () {
        if (!filter::is_account($this->data['admin_account'])) {
            $this->failure('请输入正确的账号');
        }
        $this->data['admin_salt'] = misc::randstr();
        if ($this->data['admin_email']) {
            $this->verify([
                'admin_email' => [
                    'code' => 101,
                    'msg'  => '请输入正确的邮箱',
                    'rule' => filter::$rules['email'],
                ],
            ]);
        }
        else {
            $this->data['admin_email'] = '';
        }
        if ($this->data['admin_wechat']) {
            $this->verify([
                'admin_wechat' => [
                    'code' => 102,
                    'msg'  => '请输入正确的微信号',
                    'rule' => filter::$rules['wechat'],
                ],
            ]);
        }
        else {
            $this->data['admin_wechat'] = '';
        }
        $this->data['admin_type'] = $this->data['admin_type'] ?: 1;
        if (!filter::is_account($this->data['admin_nick'])) {
            $this->failure('请输入正确名字', 101);
        }
        $this->data['admin_date_add'] = $this->data['admin_date_add'] ?: REQUEST_TIME;
        $this->data['admin_date_login'] = $this->data['admin_date_login'] ?: REQUEST_TIME;
        $this->verify([
            'admin_passwd' => [
                'code' => 103,
                'msg'  => '请输入正确的密码',
                'rule' => filter::$rules['passwd'],
            ],
            'admin_mobile' => [
                'code' => 104,
                'msg'  => '请输入正确的手机号',
                'rule' => filter::$rules['mobile'],
            ],
        ]);
        $this->data['admin_passwd'] = md5(md5($this->data['admin_passwd']) . $this->data['admin_salt']);
        $this->data['admin_group_id'] = (int)$this->data['pag_id'];
        var_dump($this->data['pag_id']);
        dump($this->data);
        $tab = OBJ('admin_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'admin/save', '2', '管理员' .
                    ($this->data['admin_id'] ? '修改[' . $this->data['admin_id'] : '新增[' . $ret['row_id']) . '@]');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc(), 105);
    }
    
    /**
     * 管理员权限组列表
     */
    public function group_action () {
        $ret = OBJ('admin_group_table')->get_all();
        if ($ret) {
            $this->success('操作成功', $ret);
        }
        $this->failure('操作失败');
    }
    
}