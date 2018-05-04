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
                'designer/get'              => '设计师详情',
                'designer/list'             => '设计师列表',
                'designer/save'             => '设计师更新',
                'designer/del'              => '设计师删除',
                'designer/case/list|designer/case/set'  => '代表作设置',
            ]
        ],
        [
            'name'      => '资讯管理',
            'actions'   => [
                'article/get'               => '资讯详情',
                'article/list'              => '资讯列表',
                'article/save'              => '资讯更新',
                'article/del'               => '资讯删除',
                'category/article/list'     => '分类列表',
                'category/article/get'      => '分类详情',
                'category/article/save'     => '分类更新',
                'category/article/del'      => '分类删除',
            ]
        ],
        [
            'name'      => '案例管理',
            'actions'   => [
                'case/get'                  => '案例详情',
                'case/list'                 => '案例列表',
                'case/save'                 => '案例更新',
                'case/del'                  => '案例删除',
                'category/case/list'        => '分类列表',
                'category/case/get'         => '分类详情',
                'category/case/save'        => '分类更新',
                'category/case/del'         => '分类删除',
            ]
        ],
        [
            'name'      => '材料管理',
            'actions'   => [
                'material/get'              => '材料详情',
                'material/list'             => '材料列表',
                'material/save'             => '材料更新',
                'material/del'              => '材料删除',
                'category/material/list'    => '分类列表',
                'category/material/get'     => '分类详情',
                'category/material/save'    => '分类更新',
                'category/material/del'     => '分类删除',
                'material/brand/get'        => '品牌详情',
                'material/brand/list'       => '品牌列表',
                'material/brand/save'       => '品牌更新',
                'material/brand/del'        => '品牌删除',
                'material/supplier/get'     => '供应商详情',
                'material/supplier/list'    => '供应商列表',
                'material/supplier/save'    => '供应商更新',
                'material/supplier/del'     => '供应商删除',
            ]
        ],
        [
            'name'      => '分类管理',
            'actions'   => [
                'category/style/list'       => '风格分类-列表',
                'category/style/get'        => '风格分类-详情',
                'category/style/save'       => '风格分类-更新',
                'category/style/del'        => '风格分类-删除',
                'category/space/list'       => '空间分类-列表',
                'category/space/get'        => '空间分类-详情',
                'category/space/save'       => '空间分类-更新',
                'category/space/del'        => '空间分类-删除',
                'category/type/list'        => '户型分类-列表',
                'category/type/get'         => '户型分类-详情',
                'category/type/save'        => '户型分类-更新',
                'category/type/del'         => '户型分类-删除',
                'category/layout/list'      => '布局分类-列表',
                'category/layout/get'       => '布局分类-详情',
                'category/layout/save'      => '布局分类-更新',
                'category/layout/del'       => '布局分类-删除',
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
     * 生成密码
     * @param  [type] $pwd  [description]
     * @param  string $salt [description]
     * @return [type]       [description]
     */
    public static function generate_passwd ($pwd, $salt = '') {
        return md5(md5($pwd) . $salt);
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
            foreach (explode('|', $k) as $key => $val) {
                $keys = explode('/', $key);
                $method = array_pop($keys) . '_action';
                $admin['allows'][join('_', $keys) . '_iface::' . $method] = true;
            }
        }
        unset($admin['pag_details']);
        if ($admin['admin_group_id'] == 1) {
            $admin['allows'] = [];
        }
        return $admin;
    }
}
