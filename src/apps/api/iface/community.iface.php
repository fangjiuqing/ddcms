<?php
namespace re\rgx;

/**
 * 小区/户型操作类
 * Class community_iface
 * @package re\rgx
 * anthor Fox
 */
class community_iface extends ubase_iface {
    
    /**
     * 获取小区/户型列表接口
     */
    public function list_action () {
        $tab = OBJ('unit_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $pco_ids = [];
        $arts = $tab->map(function ($row) use (&$pco_ids) {
            $pco_ids[$row['pu_co_id']] = 1;
            return $row;
        })->get_all();
        $region0 = [];
        $region1 = [];
        $region2 = [];
        $pco_list = OBJ('community_table')->akey('pco_id')->map(function ($row) use (&$region0, &$region1, &$region2) {
            $region0[$row['pco_region0'] . '0000']  = 1;
            $region1[$row['pco_region1'] . '00']    = 1;
            $region2[$row['pco_region2']]           = 1;
            return $row;
        })->get_all([
            'pco_id' => array_keys($pco_ids),
        ]);
        $region_tab = OBJ('region_table');
        $region0_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region0),
        ]);
        $region1_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region1),
        ]);
        $region2_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region2),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['pco_id'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_id'] : 0;
            $arts[$k]['pco_region0'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_region0'] : 0;
            $arts[$k]['pco_region1'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_region1'] : 0;
            $arts[$k]['pco_region2'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_region2'] : 0;
            $arts[$k]['pco_name'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_name'] : '';
            $arts[$k]['pco_addr'] = isset($pco_list[$v['pu_co_id']]) ? $pco_list[$v['pu_co_id']]['pco_addr'] : '';
            $arts[$k]['pco_region0_label'] = isset($arts[$k]['pco_region0']) ?
                $region0_list[$arts[$k]['pco_region0'] . '0000']['region_name'] : '';
            $arts[$k]['pco_region1_label'] = isset($arts[$k]['pco_region1']) ?
                $region1_list[$arts[$k]['pco_region1'] . '00']['region_name'] : '';
            $arts[$k]['pco_region2_label'] = isset($arts[$k]['pco_region2']) ?
                $region2_list[$arts[$k]['pco_region2']]['region_name'] : '';
        }
        $this->success('查询成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
    
}