<?php
namespace re\rgx;

/**
 * 管理员管理
 */
class system_admin_iface extends ubase_iface {
    
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
        })->order('admin_date_add desc')->get_all();
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
     * @param int $id 要删除的账号id
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
     * @param int $id 管理员id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        if ($ret = OBJ('admin_table')->get($id)) {
            unset($ret['admin_passwd']);
            unset($ret['admin_salt']);
            $this->success('操作成功', $ret);
        }
        $this->failure('操作失败');
    }
    
    /**
     * 管理员账号新增
     * @param string $admin_account  管理员账号名
     * @param int    $admin_mobile   手机号
     * @param string $admin_nick     真实姓名
     * @param int    $admin_group_id 所在组id
     */
    public function save_action () {
        if (!filter::is_account($this->data['admin_account'])) {
            $this->failure('请输入正确的账号');
        }
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
            'admin_mobile' => [
                'code' => 104,
                'msg'  => '请输入正确的手机号',
                'rule' => filter::$rules['mobile'],
            ],
        ]);
        $this->data['admin_salt'] = misc::randstr();
        if ($this->data['admin_passwd']) {
            $this->verify([
                'admin_passwd' => [
                    'code' => 103,
                    'msg'  => '请输入正确的密码',
                    'rule' => filter::$rules['passwd'],
                ],
            ]);
            $this->data['admin_passwd'] = admin_helper::generate_passwd($this->data['admin_passwd'],
                $this->data['admin_salt']);
        }
        else {
            $this->data['admin_passwd'] = admin_helper::generate_passwd('root', $this->data['admin_salt']);
        }
        $this->data['admin_group_id'] = (int)$this->data['admin_group_id'];
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
}
