<?php
namespace re\rgx;

/**
 * 管理基类
 */
class index_iface extends base_iface {
    
    /**
     * 后台管理员登录接口
     * @param string $account 用户名
     * @param string $passwd  密码
     */
    public function login_action () {
        $this->verify([
            'account' => [
                'code' => 100,
                'msg'  => '请输入有效的账号',
                'rule' => filter::$rules['uid'],
            ],
            'passwd'  => [
                'code' => 101,
                'msg'  => '请输入您的密码',
                'rule' => function ($v) {
                    return !empty($v);
                },
            ],
        ]);
        
        $tab = OBJ('admin_table');
        $admin = $tab->left_join('admin_group_table', 'admin_group_id', 'pag_id')->get([
            'admin_account' => $this->data['account'],
        ]);
        
        if (empty($admin)) {
            $this->failure('该账号不存在', 102, ['via' => 'account']);
        }
        
        if (admin_helper::verify_passwd($this->data['passwd'], $admin['admin_passwd'], $admin['admin_salt'])) {
            $this->set_login(admin_helper::get_login($admin));
            $tab->update([
                'admin_id'         => $admin['admin_id'],
                'admin_date_login' => REQUEST_TIME,
            ]);
            admin_helper::add_log($admin['admin_id'], 'index/login', 1, "{$admin['admin_nick']}登录了系统");
            $this->success('登录成功');
        }
        admin_helper::add_log($admin['admin_id'], 'index/login', 1, '密码错误');
        $this->failure('账号或密码有误', 103);
    }
    
    /**
     * 注销登录
     */
    public function logout_action () {
        if ($this->del_login()) {
            $this->success('注销成功');
        }
        $this->failure('注销失败', 100);
    }
    
}