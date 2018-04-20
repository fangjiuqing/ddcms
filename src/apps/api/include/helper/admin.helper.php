<?php
namespace re\rgx;

/**
 * admin 助手类
 */
class admin_helper extends rgx {

    /**
     * add_log接口action说明
     */
    public static $type = [
        '1' => '查询操作',
        '2' => '新增/修改操作',
        '3' => '删除操作',
    ];

    /**
     * 操作配置
     * @var [type]
     */
    public static $operate = [
        [
            'name'      => '客户模块',
            'actions'   => [
                'customer/get'              => '客户详情',
                'customer/list'             => '客户列表',
                'customer/save'             => '客户更新',
                'customer/del'              => '客户删除',
            ]
        ],
        [
            'name'      => '系统管理',
            'actions'   => [
                'system/admin/get'          => '管理详情',
                'system/admin/list'         => '管理列表',
                'system/admin/save'         => '管理更新',
                'system/admin/del'          => '管理删除',
                'system/admin/group/get'    => '权限详情',
                'system/admin/group/list'   => '权限列表',
                'system/admin/group/save'   => '权限更新',
                'system/admin/group/del'    => '权限删除',
                'system/logs'               => '日志查看',
            ]
        ],
        [
            'name'      => '设计师管理',
            'actions'   => [
                'designer/get'          => '设计师详情',
                'designer/list'         => '设计师列表',
                'designer/save'         => '设计师更新',
                'designer/del'          => '设计师删除',
            ]
        ],
        [
            'name'      => '资讯管理',
            'actions'   => [
                'article/get'               => '资讯详情',
                'article/list'              => '资讯列表',
                'article/save'              => '资讯更新',
                'article/del'               => '资讯删除',
            ]
        ],
        
    ];

    /**
     * 获取权限列表的文字说明
     * @param  [type] $list [description]
     * @return [type]       [description]
     */
    public static function get_operate_desc ($list) {
        static $operates = [];
        if (empty($operates)) {
            foreach (self::$operate as $row) {
                $operates = array_merge($operates, $row['actions']);
            }
        }
        $ret = [];
        foreach ($list as $k => $v) {
            $ret[] = $operates[$k] ?: '';
        }
        return join(", ", $ret);
    }

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

    /**
     * 获取登录信息
     * @param  [type] $admin [description]
     * @return [type]        [description]
     */
    public static function get_login ($admin) {
        $admin['allows'] = ['nil'];
        $actions = filter::json_unecsape($admin['pag_details']);
        foreach ((array)$actions as $k => $v) {
            $keys = explode('/', $k);
            $method = array_pop($keys) . '_action';
            $admin['allows'][join('_', $keys) . '_iface::' . $method] = true;
        }
        unset($admin['pag_details']);
        return $admin;
    }
}
