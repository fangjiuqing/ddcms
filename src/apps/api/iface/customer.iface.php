<?php
namespace re\rgx;

/**
 * 顾客操作类
 * @param string $uri          请求的接口
 * @param array  $data
 * @param string $access_token token
 */
class customer_iface extends base_iface {
    
    /**
     * 获取顾客列表接口
     */
    public function list_action () {
        $tab = OBJ('customer_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $region_ids = [];
        $area_ids = [];
        $arts = $tab->map(function ($row) use (&$region_ids, &$area_ids) {
            $region_ids[$row['pc_region0']] = 1;
            $region_ids[$row['pc_region1']] = 1;
            $region_ids[$row['pc_region2']] = 1;
            $area_ids[$row['pc_co_id']] = 1;
            return $row;
        })->get_all();
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
}