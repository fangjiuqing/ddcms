<?php
namespace re\rgx;

/**
 * 系统管理操作类
 */
class system_iface extends base_iface {

    /**
     * 操作日志获取接口
     */
    public function list_action () {
        $page = $this->data['page'] ?: 1;
        $offset = 10;
        $start = ($page - 1) * $offset;
        $user_ids = [];
        $arts = OBJ('admin_log_table')->map(function ($row) use (&$user_ids) {
            $user_ids[$row['al_admin_id']] = 1;
            return $row;
        })->limit($start . ',' . $offset)->get_all();
        $user_list = OBJ('admin_table')->akey('admin_id')->get_all([
            'admin_id' => array_keys($user_ids ?: [0]),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['al_adate'] = date('Y-m-d H:i:s', $v['al_adate']);
            $arts[$k]['al_ip'] = long2ip($v['al_ip']);
            $arts[$k]['al_name'] = isset($user_list[$v['al_admin_id']]) ?
                $user_list[$v['al_admin_id']]['admin_account'] : '';
            $temp = explode('[', $v['al_memo']);
            $id_title = explode('@', $temp[1]);
            $arts[$k]['al_act'] = $temp[0];
            $arts[$k]['al_action_id'] = $id_title[0];
            $arts[$k]['al_title'] = rtrim($id_title[1], ']');
        }
        $this->success('操作日志获取成功', ['list' => $arts]);
    }
}