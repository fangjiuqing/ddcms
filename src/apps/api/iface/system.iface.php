<?php
namespace re\rgx;

/**
 * 系统管理操作类
 */
class system_iface extends ubase_iface {
    
    /**
     * 操作日志列表获取接口
     */
    public function logs_action () {
        $tab = OBJ('admin_log_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $user_ids = [];
        $arts = $tab->map(function ($row) use (&$user_ids) {
            $user_ids[$row['al_admin_id']] = 1;
            return $row;
        })->order('al_adate desc')->get_all();

        $user_list = OBJ('admin_table')->akey('admin_id')->get_all([
            'admin_id' => array_keys($user_ids ?: [0]),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['al_ip'] = long2ip($v['al_ip']);
            $arts[$k]['al_name'] = $user_list[$v['al_admin_id']]['admin_nick'] ?: '-';
        }
        $this->success('操作日志获取成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
}