<?php
namespace re\rgx;

/**
 * 顾客操作类
 */
class customer_iface extends base_iface {
    
    /**
     * 获取顾客列表接口
     * @param string $uri          请求的接口
     * @param array  $data
     * @param string $access_token token
     */
    public function list_action () {
        $tab = OBJ('customer_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 2);
        $region_ids = [];
        $area_ids = [];
        $arts = $tab->map(function ($row) use (&$region_ids, &$area_ids) {
            $region_ids[$row['pc_region0']] = 1;
            $region_ids[$row['pc_region1']] = 1;
            $region_ids[$row['pc_region2']] = 1;
            $area_ids[$row['pc_co_id']] = 1;
            return $row;
        })->get_all(['pc_status_del' => 0]);
        $region_list = OBJ('region_table')->akey('region_code')->get_all([
            'region_code' => array_keys($region_ids ?: [0]),
        ]);
        $area_list = OBJ('community_table')->akey('pco_id')->get_all([
            'pco_id' => array_keys($area_ids ?: [0]),
        ]);
        foreach ($arts as $k => $v) {
            $arts[$k]['pc_region00'] = isset($region_list[$v['pc_region0']]) ?
                $region_list[$v['pc_region0']]['region_name'] : '';
            $arts[$k]['pc_region10'] = isset($region_list[$v['pc_region1']]) ?
                $region_list[$v['pc_region1']]['region_name'] : '';
            $arts[$k]['pc_region20'] = isset($region_list[$v['pc_region2']]) ?
                $region_list[$v['pc_region2']]['region_name'] : '';
            $arts[$k]['pc_area'] = isset($area_list[$v['pc_co_id']]) ? $area_list[$v['pc_co_id']]['pco_name'] : '';
        }
        $this->success('获取列表成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * 删除顾客信息
     * @param array $data 被删除用户id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('customer_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('要删除的用户信息不存在');
        }
        $this->data['pc_id'] = $id;
        $this->data['pc_status_del'] = 1;
        $result = $tab->update($this->data);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'customer/del', '3',
                '删除顾客信息成功[' . $this->login['admin_id'] . '@' . $id . ']');
            $this->success('删除成功');
        }
        admin_helper::add_log($this->login['admin_id'], 'customer/del', '3',
            '删除顾客信息失败[' . $this->login['admin_id'] . '@' . $id . ']');
        $this->failure('删除失败', '101');
    }
}