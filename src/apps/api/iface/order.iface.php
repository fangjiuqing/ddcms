<?php
namespace re\rgx;

/**
 * 客户预约类
 */
class order_iface extends ubase_iface {
    
    /**
     * 顾客预约列表接口
     */
    public function list_action () {
        $tab = OBJ('customer_order_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $type_ids = [];
        $pc_ids = [];
        $admin_ids = [];
        $ret = $tab->map(function ($row) use (&$type_ids, &$pc_ids, &$admin_ids) {
            $type_ids[$row['pco_type']] = 1;
            $pc_ids[$row['pco_pc_id']] = 1;
            $admin_ids[$row['pco_admin_id']] = [];
            return $row;
        })->get_all();
        $pc_rets = OBJ('customer_table')->akey('pc_id')->get_all([
            'pc_id' => array_keys($pc_ids ?: [0]),
        ]);
        $admin_rets = OBJ('admin_table')->akey('admin_id')->get_all([
            'admin_id' => array_keys($admin_ids ?: [0]),
        ]);
        foreach ((array)$ret as $k => $v) {
            $ret[$k]['pco_pc_name'] = isset($pc_rets[$v['pco_pc_id']]) ? $pc_rets[$v['pco_pc_id']]['pc_nick'] : '';
            $ret[$k]['pco_admin_name'] = isset($admin_rets[$v['pco_admin_id']]) ?
                $admin_rets[$v['pco_admin_id']]['admin_account'] : '';
            $ret[$k]['pco_type_name'] = isset(core_helper::$customer_via[$v['pco_type']]) ?
                core_helper::$customer_via[$v['pco_type']] : '';
        }
        $this->success('获取列表成功', [
            'list'   => array_values($ret),
            'paging' => $paging->to_array(),
        ]);
    }
    
}