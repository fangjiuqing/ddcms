<?php
namespace re\rgx;

/**
 * 客户预约管理
 */
class customer_order_iface extends ubase_iface {

    /**
     * 保存
     * @return [type] [description]
     */
    public function save_action () {
        $order = $this->data['data'];
        $this->verify([
            'pco_pc_id' => [
                'code' => '1',
                'msg'  => '无效的客户ID',
                'rule' => ['re\\rgx\\filter', 'is_positive_int']
            ],
            'pco_type' => [
                'code' => '1',
                'msg'  => '请选择预约服务类型',
                'rule' => function ($v) {
                    return isset(core_helper::$order_type[$v]);
                }
            ],
            'timestr'  => [
                'code' => '1',
                'msg'  => '请选择预约时间',
                'rule' => function ($v) {
                    return preg_match('/^\d{4}\-\d{1,2}\-\d{1,2} \d{1,2}\:\d{1,2}:\d{1,2}$/', $v);
                }
            ],
        ], $order);
        $order['pco_id'] = 0;
        $order['pco_stime'] = strtotime($order['timestr']);
        $order['pco_etime'] = 0;
        $order['pco_admin_id'] = $this->login['admin_id'];
        $order['pco_sms_send'] = $order['pco_sms_send'] ? 1 : 0;
        $order['pco_atime'] = REQUEST_TIME;
        $tab = OBJ('customer_order_table');
        if ($tab->load($order)) {
            $ret = $tab->save($order);
            if ($ret['code'] === 0) {
                $cus = OBJ('customer_table')->get($order['pco_pc_id']);
                if ($order['pco_sms_send']) {
                    task_helper::send_notice($cus['pc_mobile'], $order['pco_type'], 
                        $order['pco_stime'], $this->login['admin_mobile'], $this->login['admin_nick']);
                }
                admin_helper::add_log($this->login['admin_id'], 'customer/order/save', '2', 
                    "新增了" . core_helper::$order_type[$order['pco_type']] . "预约[{$cus['pc_id']}@{$cus['pc_nick']}]");
                $this->success('添加成功', [
                    'order' => $tab->get($ret['row_id'])
                ]);
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 获取预约列表
     * @return [type] [description]
     */
    public function list_action () {
        $this->success('', [
            'orders'    => OBJ('customer_order_table')->order('pco_atime desc')->get_all([
                'pco_pc_id' => (int)$this->data['id'],
            ]) ?: []
        ]);
    }
}
