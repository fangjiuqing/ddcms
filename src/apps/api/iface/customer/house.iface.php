<?php
namespace re\rgx;

/**
 * Class customer_house_iface
 * @package re\rgx
 */
class customer_house_iface extends ubase_iface {
    
    /**
     * 客户房型信息获取
     * @param int $id 客户id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $ret = OBJ('customer_table')->left_join('customer_house_table', 'pch_pc_id', $id)->get($id) ?: null;
        $ret['type'] = core_helper::$house_type;
        $ret['mode'] = core_helper::$house_mode;
        $ret['style'] = core_helper::$house_style;
        $ret['exists'] = core_helper::$house_exists;
        $this->success('操作成功', $ret);
    }
    
    public function save_action () {
        $this->data['pct_adm_id']   = $this->login['admin_id'];
        $this->data['pct_adm_nick'] = $this->login['admin_account'];
        $this->data['pct_cus_id']   = intval($this->data['pc_id']);
        $this->data['pct_memo']     = '修改客户房型信息';
        $this->data['pct_atime']    = REQUEST_TIME;
        OBJ('customer_trace_table')->insert($this->data);
        $this->data['pch_id']       = (int)$this->data['pch_id'];
        $this->data['pch_pc_id']    = (int)$this->data['pch_pc_id'];
        $this->data['pch_type']     = (int)$this->data['pch_type'];
        $this->data['pch_mode']     = (int)$this->data['pch_mode'];
        $this->data['pch_style']    = (int)$this->data['pch_style'];
        $this->data['pch_area']     = number_format($this->data['pch_area'], 2);
        $this->data['pch_area_use'] = number_format($this->data['pch_area_use'], 2);
        $this->data['pch_floor']    = (int)$this->data['pch_floor'];
        $this->data['pch_exists']   = (int)$this->data['pch_exists'];
        $this->data['pch_gtime']    = (int)$this->data['pch_gtime'];
        $this->data['pch_budget']    = number_format($this->data['pch_budget'], 2) ?: 0.00;
        $house_tab = OBJ('customer_house_table');
        if ($house_tab->load($this->data)) {
            $house_ret = $house_tab->save();
            if ($house_ret['code'] === 0) {
                $this->success('操作成功');
            }
        }
        $this->failure($house_tab->get_error_desc());
    }
    
}