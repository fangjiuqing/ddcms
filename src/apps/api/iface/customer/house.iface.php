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
        $this->success('操作成功', $ret);
    }
    
    public function save_action () {
    
    }
    
}