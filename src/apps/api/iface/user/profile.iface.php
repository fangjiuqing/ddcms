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
            OBJ('admin_table')->fields('admin_id,admin_mobile,admin_email')->get($this->login['admin_id'])
        );
    }

    /**
     * 资料更新
     * @return [type] [description]
     */
    public function save_action () {
        if ($this->data['admin_id'] != $this->login['admin_id']) {
            $this->failure('无权进行该操作');
        }
        $out['relogin'] = false;

        // 待更新数据
        $fields = [
            'admin_id'      => $this->data['admin_id'],
            'admin_email'   => $this->data['admin_email'],
            'admin_mobile'  => $this->data['admin_mobile']
        ];

        // 修改密码
        if (!empty($this->data['passwd'])) {
            if (!admin_helper::verify_passwd($this->data['passwd'], $this->login['admin_passwd'], $this->login['admin_salt'])) {
                $this->failure('当前密码错误');
            }
            if (empty($this->data['passwd1']) || empty($this->data['passwd2'])) {
                $this->failure('请输入新密码及确认密码');
            }
            if ($this->data['passwd1'] !== $this->data['passwd2']) {
                $this->failure('两次输入的密码不一致');
            }
            $fields['admin_passwd'] = admin_helper::generate_passwd($this->data['passwd1'], $this->login['admin_salt']);
            $out['relogin'] = true;
        }

        if (OBJ('admin_table')->update($fields)['code'] === 0) {
            $this->success('更新成功', $out);
        }
        $this->failure('更新失败了');
    }
}
