<?php
namespace re\rgx;

/**
 * Class customer_log_iface
 * @package re\rgx
 */
class customer_log_iface extends ubase_iface {
    
    /**
     * 顾客操作记录列表
     * @param int $id 用户id
     */
    public function list_action () {
        $id = intval($this->data['id']);
        $trace_ret = OBJ('customer_table')->left_join('customer_trace_table', 'pc_id', 'pct_cus_id')->order('pct_atime desc')->get_all(['pc_id' => $id]);
        $this->success('操作成功', $trace_ret);
    }
    
}