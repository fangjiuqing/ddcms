<?php
namespace re\rgx;

/**
 * Class customer_region_iface
 * @package re\rgx
 */
class customer_region_iface extends ubase_iface {
    
    /**
     * 小区模糊查询
     * @param string $region_name 小区名
     */
    public function get_action () {
        if (!$this->data['region_name']) {
            $this->success('操作成功');
        }
        $ret = OBJ('community_table')->akey('pco_id')->where([
            'pco_name like \'' . $this->data['region_name'] . '%\'',
        ])->limit(10)->get_all() ?: [];
        $this->success('操作成功', $ret);
    }
    
}