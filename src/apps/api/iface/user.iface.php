<?php
namespace re\rgx;

/**
 * @name 用户基本操作
 */
class user_iface extends base_iface {

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

        if (user_helper::verify_passwd($this->data['passwd'], $user['admin_passwd'], $user['admin_salt'])) {
            $this->set_login($user);
            $tab->where(['admin_account' => $this->data['account']])->update(['admin_date_login' => time()]);
            $this->success('登录成功');
        }
        admin_helper::add_log($user['admin_id'], 'user/login', 1, '密码错误');
        $this->failure('账号或密码有误', 103);
    }

    /**
     * 注销登录接口
     * @uri [string] [user/logout]
     * @access_token [string] [用户私有token]
     * @return [type] [description]
     */
    public function logout_action () {
        admin_helper::add_log($this->login['admin_id'], 'user/logout', 1, '退出登录');
        $this->sess_del(['pfm_login', 'pfm_lastip']);
        $this->success('操作成功');
    }

    /**
     * 找回密码--输入用户名邮箱[mobile]发送验证码接口
     * @uri [string] [请求的接口user/getpwd]
     * @data [array] ['account' => 'phphlx', 'email' => 'abc@163.com']
     * @data [array] ['account' => 'phphlx', 'mobile' => '12345']
     */
    public function getpwd_action () {
        $str = misc::randstr();
        $tab = OBJ('admin_table');
        if (isset($this->data['email'])) {
            $this->verify([
                'account' => [
                    'code' => 101,
                    'msg' => '请输入正确的用户名',
                    'rule' => filter::$rules['uid']
                ],
                'email' => [
                    'code' => 102,
                    'msg' => '请输入正确的邮箱',
                    'rule' => filter::$rules['email']
                ]
            ]);

            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_email' => $this->data['email']
            ]);
            if (empty($user)) {
                $this->failure('请确认输入的账号或邮箱', '103', '');
            }

            OBJ('verify_table')->insert([
                'verify_code' => $str,
                'verify_type' => 1,
                'verify_user_id' => $user['admin_id'],
                'verify_desc' => '找回密码',
                'verify_adate' => time(),
                'verify_status' => 0
            ]);
            //将通过邮件发送的验证码/邮箱存到redis, 等待脚本发送邮件

            $this->success('验证码已发送至邮箱5分钟内有效，请前往邮箱查看', '', '201');
        }
        else if (isset($this->data['mobile'])) {
            $this->verify([
                'account' => [
                    'code' => 104,
                    'msg' => '请输入正确的用户名',
                    'rule' => filter::$rules['uid']
                ],
                'mobile' => [
                    'code' => 105,
                    'msg' => '请输入正确的手机号',
                    'rule' => filter::$rules['mobile']
                ]
            ]);

            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_mobile' => $this->data['mobile']
            ]);
            if (empty($user)) {
                $this->failure('请确认输入的账号或手机号', '106', '');
            }

            OBJ('verify_table')->insert([
                'verify_code' => $str,
                'verify_type' => 2,
                'verify_user_id' => $user['admin_id'],
                'verify_desc' => '找回密码',
                'verify_adate' => time(),
                'verify_status' => 0
            ]);

            //将通过短信发送的验证码/用户名/手机号存到redis 通过脚本发送短信
            $this->success('验证码已发送至手机', '', '202');
        }
    }

    /**
     * 找回密码--验证验证码接口
     * @uri [string] [user/getpwd_code]
     * @data [array] ['account' => 'phphlx', 'email' => 'abc@qq.com', 'code' => 'xyab']
     * @data [array] ['account' => 'phphlx', 'mobile' => 17633905735, 'code' => 'xyab']
     */
    public function getpwd_code_action () {
        $tab = OBJ('admin_table');
        if (isset($this->data['email'])) {
            $this->verify([
                'account' => [
                    'code' => 100,
                    'msg' => '请输入正确的账号',
                    'rule' => filter::$rules['uid']
                ],
                'email' => [
                    'code' => 101,
                    'msg' => '请输入正确的邮箱',
                    'rule' => filter::$rules['email']
                ]
            ]);
            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_email' => $this->data['email']
            ]);
        }
        else if (isset($this->data['mobile'])) {
            $this->verify([
                'account' => [
                    'code' => 102,
                    'msg' => '请输入正确的账号',
                    'rule' => filter::$rules['uid']
                ],
                'email' => [
                    'code' => 103,
                    'msg' => '请输入正确的手机号',
                    'rule' => filter::$rules['mobile']
                ]
            ]);
            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_mobile' => $this->data['mobile']
            ]);
        }

        //通过验证码与redis里验证码作对比
        OBJ('verify_table')->where(['verify_user_id' => $user['admin_id']])->update(['verify_status' => 2]);
        $this->success('修改密码验证码正确', '201', '');
    }

    /**
     * 找回密码--重置密码接口
     * @uri [string] [user/resetpwd]
     * @data [array] ['account' => 'phphlx', 'email' => 'abc@qq.com', 'passwd' => 'abc', 'repasswd' => 'abc']
     * @data [array] ['account' => 'phphlx', 'mobile' => 17633905735, 'passwd' => 'abc', 'repasswd' => 'abc']
     */
    public function getpwd_reset_action () {
        $tab = OBJ('admin_table');
        if (isset($this->data['email'])) {
            $this->verify([
                'account' => [
                    'code' => 100,
                    'msg' => '请输入正确的账号',
                    'rule' => filter::$rules['uid']
                ],
                'email' => [
                    'code' => 101,
                    'msg' => '请输入正确的邮箱',
                    'rule' => filter::$rules['email']
                ],
                'passwd' => [
                    'code' => 102,
                    'msg' => '请输入正确的密码',
                    'rule' => filter::$rules['passwd']
                ]
            ]);
            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_email' => $this->data['email']
            ]);
        }
        else if (isset($this->data['mobile'])) {
            $this->verify([
                'account' => [
                    'code' => 103,
                    'msg' => '请输入正确的账号',
                    'rule' => filter::$rules['uid']
                ],
                'mobile' => [
                    'code' => 104,
                    'msg' => '请输入正确的手机号',
                    'rule' => filter::$rules['mobile']
                ],
                'passwd' => [
                    'code' => 105,
                    'msg' => '请输入正确的密码',
                    'rule' => filter::$rules['passwd']
                ]
            ]);
            $user = $tab->get([
                'admin_account' => $this->data['account'],
                'admin_mobile' => $this->data['mobile']
            ]);
        }

        if ($this->data['passwd'] != $this->data['repasswd']) {
            $this->failure('两次密码不一致，请重新输入。', '106', '');
        }

        $pwd = md5(md5($this->data['passwd']) . $user['admin_salt']);
        $result = $tab->where(['admin_id' => $user['admin_id']])->update(['admin_passwd' => $pwd]);

        if ($result['rows']) {
            admin_helper::add_log($user['admin_id'], 'user/resetpwd', '2', '密码重置成功');
            $this->success('密码重置成功', '', '202');
        }
        admin_helper::add_log($user['admin_id'], 'user/resetpwd', '2', '密码重置失败');
        $this->failure('密码重置失败', '107', '');
    }

}