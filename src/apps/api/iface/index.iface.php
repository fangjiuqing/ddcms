<?php
namespace re\rgx;

/**
 * 管理基类
 */
class index_iface extends base_iface {

    /**
     * 用户登录接口
     * @uri [string] [请求的接口user/login]
     * @data [array] ["account" => "用户名", "passwd" => "密码"]
     */
    public function login_action () {
        $this->verify([
            'account' => [
                'code' => 100,
                'msg' => '请输入有效的账号',
                'rule' => filter::$rules['uid']
            ],
            'passwd' => [
                'code' => 101,
                'msg' => '请输入您的密码',
                'rule' => function ($v) {
                    return !empty($v);
                }
            ],
        ]);

        $tab = OBJ('admin_table');
        $user = $tab->get([
            'admin_account' => $this->data['account']
        ]);

        if (empty($user)) {
            $this->failure('该账号不存在', 102, ['via' => 'account']);
        }

        if (admin_helper::verify_passwd($this->data['passwd'], $user['admin_passwd'], $user['admin_salt'])) {
            $this->set_login($user);
            $tab->where(['admin_account' => $this->data['account']])->update(['admin_date_login' => time()]);
            $this->success('登录成功');
        }
        admin_helper::add_log($user['admin_id'], 'index/login', 1, '密码错误');
        $this->failure('账号或密码有误', 103);
    }

}