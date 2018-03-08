<?php
namespace re\rgx;

/**
 * @name 用户基本操作
 */
class user_iface extends admin_iface {

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
}