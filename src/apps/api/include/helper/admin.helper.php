<?php
namespace re\rgx;

/**
 * admin 助手类
 */
class admin_helper extends rgx {

    /**
     * 验证用户密码
     * @param  [type] $src_pwd [description]
     * @param  [type] $passwd  [description]
     * @param  string $salt    [description]
     * @return [type]          [description]
     */
    public static function verify_passwd ($src_pwd, $passwd, $salt = '') {
        return md5(md5($src_pwd) . $salt) === $passwd;
    }

    /**
     * 添加管理员操作日志
     * @param [type]  $admin  [description]
     * @param [type]  $url    [description]
     * @param integer $action [description]
     * @param string  $desc   [description]
     */
    public static function add_log ($admin_id, $url, $action = 1, $desc = '') {
        $tab = OBJ('admin_log_table');
        if ($tab->load([
                'al_admin_id'   => $admin_id,
                'al_action'     => $action,
                'al_url'        => $url,
                'al_year'       => date('Y', app::get_time()),
                'al_month'      => date('m', app::get_time()),
                'al_day'        => date('d', app::get_time()),
                'al_adate'      => app::get_time(),
                'al_memo'       => $desc,
                'al_ip'         => ip2long(app::get_ip())
            ])) {
            return $tab->insert()['code'] === 0;
        }
        return false;
    }
}