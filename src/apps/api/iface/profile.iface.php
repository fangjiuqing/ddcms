<?php
namespace re\rgx;

/**
 * @name 用户信息修改
 *
 */
class profile_iface extends check_iface {

    /**
     * 用户修改密码接口
     * @uri [string] [profile/passwd]
     * @access_token [string] [用户私有token]
     * @data [array] ['passwd' => 'abc', 'newpwd' => 'xyz', 'renewpwd' => 'xyz']
     */
    public function passwd_action () {
        $tab = OBJ('admin_table');
        $this->verify([
            'passwd' => [
                'code' => 101,
                'msg' => '请输入有效的密码',
                'rule' => filter::$rules['passwd']
            ],
            'newpwd' => [
                'code' => 102,
                'msg' => '请输入有效的新密码',
                'rule' => filter::$rules['passwd']
            ]
        ]);

        if ($this->data['passwd'] == $this->data['newpwd']) {
            $this->failure('新密码与旧密码相同', '103', '');
        }

        if ($this->data['newpwd'] != $this->data['renewpwd']) {
            $this->failure('两次密码不一致', '104', '');
        }

        $result = $tab->get(['admin_id' => $this->login['admin_id']]);
        if (!user_helper::verify_passwd($this->data['passwd'], $result['admin_passwd'], $this->login['admin_salt'])) {
            admin_helper::add_log($this->login['admin_id'], 'profile/passwd', 2, '密码错误');
            $this->failure('密码有误', 105);
        }

        $newpwd = md5(md5($this->data['newpwd']) . $this->login['admin_salt']);
        $result = $tab->where(['admin_id' => $this->login['admin_id']])->update(['admin_passwd' => $newpwd]);

        if (!$result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/passwd', 2, '修改失败');
            $this->failure('密码修改失败', 106);
        }
        admin_helper::add_log($this->login['admin_id'], 'profile/passwd', 2, '修改成功');
        $this->success('密码修改成功', '', '201');
    }

    /**
     * 绑定邮箱--判断邮箱是否绑定/激活
     * @uri [string] [profile/email]
     * @access_token [string] [用户私有token]
     */
    public function email_action () {
        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_email']) {
            $this->success('邮箱已激活', [
                'active_email' => $user['admin_email'],
                'status' => 1
            ], '201');
        }

        $verify = OBJ('verify_table')->get([
            'verify_user_id' => $this->login['admin_id'],
            'verify_type' => 1,
            'verify_category' => 1,
            'verify_status' => [0, 1, 2]
        ]);
        if ($verify) {
            $this->success('邮箱已绑定, 请激活', ['bind_email' => $verify['verify_bind'], 'status' => 2], '202');
        }
        $this->failure('尚未绑定激活邮箱', '100', '');
    }

    /**
     * 绑定邮箱接口--绑定邮箱
     * @uri [string] [profile/email_bind]
     * @access_token [string] [用户token]
     * @data [array] ['email' => 'phphlx@163.com']
     */
    public function email_bind_action () {
        $this->verify([
            'email' => [
                'code' => 100,
                'msg' => '请输入有效的邮箱',
                'rule' => filter::$rules['email']
            ]
        ]);

        $user = OBJ(admin_table)->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_email'] == $this->data['email']) {
            $this->failure('更新邮箱与原邮箱相同', '101');
        }

        $is_active = OBJ('admin_table')->get(['admin_email' => $this->data['email']]);
        $is_band = OBJ('verify_table')->get([
            'verify_bind' => $this->data['email'],
            'verify_status' => [0, 1, 2]
        ]);
        if ($is_active || $is_band) {
            admin_helper::add_log($this->login['admin_id'], 'profile/email_bind', '2', '邮箱被占用');
            $this->failure('该邮箱已被使用', '102', '');
        }

        $str = misc::randstr();
        $result = OBJ('verify_table')->insert([
            'verify_code' => $str,
            'verify_type' => 1,
            'verify_email' => $this->data['email'],
            'verify_user_id' => $this->login['admin_id'],
            'verify_category' => 1,
            'verify_bind' => $this->data['email'],
            'verify_desc' => '绑定邮箱',
            'verify_adate' => time(),
            'verify_status' => '0'
        ]);
        //邮箱, 验证码放入redis 等待脚本发送激活码邮件
        //$data = ['email_code' => $str, 'email' => $this->data['email], 'account' => $this->login['account']];

        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/email_bind', '2', '邮箱绑定成功');
            $this->success('邮箱绑定成功，激活码已发送至邮箱，5分钟内有效。', '', '201');
            //shell发送邮件
        }
        admin_helper::add_log($this->login['admin_id'], 'profile/email_bind', '2', '邮箱绑定失败');
        $this->failure('邮箱绑定失败', '103');
    }

    /**
     * 邮箱解绑接口
     * @uri [string] [profile/email_unbind]
     * @access_token [string] [私有token]
     * @data [array] ['email' => 'abc@qq.com']
     */
    public function email_unbind_action () {
        $tab = OBJ('admin_table');
        $this->verify([
            'email' => [
                'code' => 101,
                'msg' => '请输入有效的邮箱',
                'rule' => filter::$rules['email']
            ]
        ]);

        $result = $tab->get(['admin_id' => $this->login['admin_id']]);
        if ($result['admin_email'] == $this->data['email']) {
            $tab->where(['admin_id' => $this->login['admin_id']])->update(['admin_email' => ' ']);
            admin_helper::add_log($this->login['admin_id'], 'profile/email_unbind', '2', '邮箱解绑成功');
            $this->success('邮箱解绑成功', '', '201');
        }

        $verify = OBJ('verify_table')->get([
            'verify_bind' => $this->data['email'],
            'verify_status' => [0, 1, 2]
        ]);
        if ($verify['verify_bind'] == $this->data['email']) {
            OBJ('verify_table')->where(['verify_bind' => $this->data['email'], 'verify_status' => [0, 1, 2]])->update(['verify_status' => 3]);
            admin_helper::add_log($this->login['admin_id'], 'profile/email_unbind', '2', '邮箱解绑成功');
            $this->success('邮箱解绑成功', '', '202');
        }
        $this->failure('邮箱解绑失败', '102', '');
    }

    /**
     * 激活邮箱接口
     * @uri [string] [profile/email_active]
     * @access_toke [string] [用户token]
     * @data [array] ['code' => 'xyai']
     */
    public function email_active_action () {
        //通过redis查看验证信息是否过期

        if ('与redis对比验证码失败') {//哎呀Redis没写
            $this->failure('验证码有误，请重新激活', '103', '');
            admin_helper::add_log($this->login['admin_id'], 'profile/email_active', '2', '验证码错误邮箱激活失败');
        }
        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_email' => '验证的邮箱']);//哎呀, Redis没写
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/email_active', '2', '邮箱激活成功');
            OBJ('verify_table')->where(['verify_user_id' => $this->login['admin_id']])->update(['verify_status' => 2]);
            $this->success('邮箱激活成功', '', '201');
        }
        admin_helper::add_log($this->login['admin_id'], 'profile/email_active', '2', '邮箱激活失败');
        $this->failure('邮箱激活失败', '104', '');
    }

    /**
     * 绑定手机号--判断是否绑定接口
     * @uri [string] [profile/mobile]
     * @access_token [string] [用户私有token]
     */
    public function mobile_action () {
        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_mobile']) {
            $this->success('该用户已绑定手机号', ['account_mobile' => $user['admin_mobile'], 'status' => '1'], '201');
        }

        $verify = OBJ('verify_table')->get([
            'verify_user_id' => $this->login['admin_id'],
            'verify_type' => 2,
            'verify_category' => 2,
            'verify_status' => [0, 1, 2]
        ]);
        if ($verify) {
            $this->success('手机号已绑定, 请激活', ['bind_email' => $verify['verify_bind'], 'status' => 2], '202');
        }
        $this->failure('尚未绑定激活手机号', '100', '');
    }

    /**
     * 绑定手机号--绑定接口
     * @uri [string] [profile/mobile_bind]
     * @access_token [string] [用户私有token]
     * @data [array] ['mobile' => '17633905735']
     */
    public function mobile_bind_action () {
        $this->verify([
            'mobile' => [
                'code' => 100,
                'msg' => '请输入正确的手机号',
                'rule' => filter::$rules['mobile']
            ]
        ]);

        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_mobile'] == $this->data['mobile']) {
            $this->failure('更新手机号与原手机号相同', '101');
        }

        $is_exists = OBJ('admin_table')->get(['admin_mobile' => $this->data['mobile']]);
        $is_band = OBJ('verify_table')->get([
            'verify_mobile' => $this->data['mobile'],
            'verify_status' => [0, 1, 2]
        ]);
        if ($is_exists || $is_band) {
            admin_helper::add_log($this->login['admin_id'], 'profile/mobile_bind', '2', '手机号占用绑定失败');
            $this->failure('手机号已被占用', '102', '');
        }

        $str = misc::randstr();
        $result = OBJ('verify_table')->insert([
            'verify_code' => $str,
            'verify_type' => 2,
            'verify_mobile' => $this->data['mobile'],
            'verify_user_id' => $this->login['admin_id'],
            'verify_category' => 2,
            'verify_bind' => $this->data['mobile'],
            'verify_desc' => '绑定手机号',
            'verify_adate' => time(),
            'verify_status' => '0'
        ]);

        if (!$result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/mobile_bind', '2', '写入数据库失败绑定失败');
            $this->failure('手机号绑定失败', '102', '');
        }

        //验证信息存入redis或调短信接口发送
        //$data = ['mobile' => 1763390, 'mobile_code' => $str];

        $this->success('验证码已发送至手机, 有效期5分钟', '', '201');
    }

    /**
     * 绑定手机号--解绑手机号接口
     * @uri [string] [profile/mobile_unbind]
     * @access_token [string] ['abasdfasgasdf']
     * @data [array] ['mobile' => '17633905735']
     */
    public function mobile_unbind_action () {
        $this->verify([
            'mobile' => [
                'code' => 100,
                'msg' => '不合法的手机号',
                'rule' => filter::$rules['mobile']
            ]
        ]);

        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_mobile'] == $this->data['mobile']) {
            OBJ('admin_table')->where(['admin_id' => $user['admin_id']])->update(['admin_mobile' => ' ']);
            admin_helper::add_log($user['admin_id'], 'profile/mobile_unbind', '2', '解绑成功');
            $this->success('手机号解绑成功', '', '201');
        }

        $verify = OBJ('verify_table')->get([
            'verify_bind' => $this->data['mobile'],
            'verify_status' => [0, 1, 2]
        ]);
        if ($verify['verify_bind'] == $this->data['mobile']) {
            OBJ('verify_table')->where(['verify_bind' => $this->data['mobile'], 'verify_status' => [0, 1, 2]])->update(['verify_status' => 3]);
            admin_helper::add_log($user['admin_id'], 'profile/mobile_unbind', '2', '解绑手机号');
            $this->success('解绑手机号成功', '', '202');
        }

        $this->failure('解绑手机号失败', '101', '');
    }

    /**
     * 绑定手机号--激活手机号接口
     * @uri [string] [profile/mobile_active]
     * @access_token [string] [私有token]
     * @data [array] ['code' => 'abxy']
     */
    public function mobile_active_action () {
        //与Redis对比是否过期

        $this->verify([
            'mobile' => [
                'code' => '102',
                'msg' => '验证码错误',
                'rule' => filter::$rules['mobile']
            ]
        ]);

        //与Redis对比是否正确

        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_mobile' => '从redis获取邮箱']);
        if (!$result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/mobile_active', '2', '绑定手机号失败');
            $this->failure('绑定手机号失败', '104', '');
        }

        OBJ('verify_table')->where(['verify_user_id' => $this->login['admin_id']])->delete();
        admin_helper::add_log($this->login['admin_id'], 'profile/mobile_active', '2', '绑定手机号成功');
        $this->success('手机号绑定成功', '', '201');
    }

    /**
     * 绑定微信号--判断微信号是否绑定
     * @uri [string] [profile/wechat]
     * @access_token [string] [''asdfasrwer]
     */
    public function wechat_action () {
        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_wechat']) {
            $this->success('用户已绑定微信号', ['wechat' => $user['admin_wechat']], '201');
        }
        $this->failure('您尚未绑定微信号', '100', '');
    }

    /**
     * 绑定微信号--绑定微信号接口
     * @uri [string] [profile/wechat_bind]
     * @access_token [string] ['asdfasgasdfg]
     * @data [array] ['wechat' => 'atinyhan']
     */
    public function wechat_bind_action () {
        $this->verify([
            'wechat' => [
                'code' => 100,
                'msg' => '不合法的微信号',
                'rule' => filter::$rules['wechat']
            ]
        ]);

        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_wechat'] == $this->data['wechat']) {
            $this->failure('新微信号与旧微信号相同', '101', '');
        }

        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_wechat' => $this->data['wechat']]);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/wechat_bind', '2', '绑定成功');
            $this->success('绑定微信号成功', '', '201');
        }

        admin_helper::add_log($this->login['admin_id'], 'profile/wechat_bind', '2', '绑定失败');
        $this->failure('绑定微信号失败', '102', '');
    }

    /**
     * 解绑微信号
     * @uri [string] [profile/wechat_unbind]
     * @access_token [string] ['asdfqwer']
     */
    public function wechat_unbind_action () {
        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_wechat' => ' ']);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/wechat_unbind', '2', '解绑成功');
            $this->success('解绑微信号成功', '', '200');
        }

        admin_helper::add_log($this->login['admin_id'], 'profile/wechat_unbind', '2', '解绑失败');
        $this->failure('解绑微信号失败', '100', '');
    }

    /**
     * 绑定qq号--判断qq号是否绑定
     * @uri [string] [profile/qq]
     * @access_token [string] [''asdfasrwer]
     */
    public function qq_action () {
        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_qq']) {
            $this->success('用户已绑定qq号', ['qq' => $user['admin_qq']], '201');
        }
        $this->failure('您尚未绑定qq号', '100', '');
    }

    /**
     * 绑定qq号--绑定qq号接口
     * @uri [string] [profile/qq_bind]
     * @access_token [string] ['asdfasgasdfg]
     * @data [array] ['qq' => '1059099978']
     */
    public function qq_bind_action () {
        $this->verify([
            'qq' => [
                'code' => 100,
                'msg' => '不合法的qq号',
                'rule' => filter::$rules['qq']
            ]
        ]);

        $user = OBJ('admin_table')->get(['admin_id' => $this->login['admin_id']]);
        if ($user['admin_qq'] == $this->data['qq']) {
            $this->failure('新qq号与旧qq号相同', '101', '');
        }

        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_qq' => $this->data['qq']]);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/qq_bind', '2', '绑定成功');
            $this->success('绑定qq号成功', '', '201');
        }

        admin_helper::add_log($this->login['admin_id'], 'profile/qq_bind', '2', '绑定失败');
        $this->failure('绑定qq号失败', '102', '');
    }

    /**
     * 解绑qq号
     * @uri [string] [profile/qq_unbind]
     * @access_token [string] ['asdfqwer']
     */
    public function qq_unbind_action () {
        $result = OBJ('admin_table')->where(['admin_id' => $this->login['admin_id']])->update(['admin_qq' => ' ']);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'profile/qq_unbind', '2', '解绑成功');
            $this->success('解绑qq号成功', '', '200');
        }

        admin_helper::add_log($this->login['admin_id'], 'profile/qq_unbind', '2', '解绑失败');
        $this->failure('解绑qq号失败', '100', '');
    }

}
