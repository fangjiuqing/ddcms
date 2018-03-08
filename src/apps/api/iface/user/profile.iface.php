<?php
namespace re\rgx;

/**
 * 用户信息接口
 */
class user_profile_iface extends user_iface {

    /**
     * 获取信息
     * @return [type] [description]
     */
    public function get_action () {
        $this->success('', 
            OBJ('admin_table')->fields('admin_id,admin_nick,admin_mobile,admin_email')->get($this->login['admin_id'])
        );
    }

    /**
     * 资料更新
     * @return [type] [description]
     */
    public function save_action () {
        $this->verify([
            'admin_nick' => [
                'code'          => 100,
                'msg'           => '请输入有效的姓名',
                'rule'          => function ($v) {
                    return !empty($v) && filter::is_account($v);
                }
            ],
            'admin_mobile' => [
                'code'          => 101,
                'msg'           => '请输入有效的手机号码',
                'rule'          => filter::$rules['mobile'],
            ],
            'admin_email' => [
                'code'          => 101,
                'msg'           => '请输入有效的邮箱地址',
                'rule'          => filter::$rules['email']
            ]
        ]);

        if ($this->data['admin_id'] != $this->login['admin_id']) {
            $this->failure('无权进行该操作');
        }

        $ret = OBJ('admin_table')->update([
            'admin_id'      => $this->login['admin_id'],
            'admin_nick'    => $this->data['admin_nick'],
            'admin_email'   => $this->data['admin_email'],
            'admin_mobile'  => $this->data['admin_mobile']
        ]);
        if ($ret['code'] === 0) {
            $this->success('更新成功');
        }
        $this->failure('更新失败了');

    }
}