<?php
namespace re\rgx;

/**
 * Class unit
 * @package re\rgx
 * anthor Fox
 */
class unit_iface extends ubase_iface {
    
    public function list_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('community_copy_table');
        $ret = $tab->get($id);
        $tab->where([
            'pco_region0' => $ret['pco_region0']
        ]);
        if ($ret['pco_region1']) {
            $tab->where([
                'pco_region1' => $ret['pco_region1'],
            ]);
        }
        if ($ret['pco_region2']) {
            $tab->where([
                'pco_region2' => $ret['pco_region2'],
            ]);
        }
        $pco_ids = [];
        $tab->map(function ($row) use (&$pco_ids) {
            $pco_ids[$row['pco_id']] = 1;
        })->get_all([
            'pco_name' => $ret['pco_name'],
        ]);
        $unit_tab = OBJ('unit_copy_table');
        $paging = new paging_helper($unit_tab, $this->data['pn'] ?: 1, 4);
        $pu_list = $unit_tab->get_all([
            'pu_co_id' => array_keys($pco_ids),
        ]);
        foreach ((array)$pu_list as $k => $v) {
            $pu_list[$k]['pu_cover_thumb'] = IMAGE_URL . $v['pu_cover'] . '!500x309';
        }
        $this->success('操作成功', [
            'arts'      => array_values($pu_list),
            'paging'    => $paging->to_array(),
        ]);
    }
    
}