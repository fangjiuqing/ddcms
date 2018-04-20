<?php
namespace re\rgx;

/**
 * 客户信息接口类
 */
class public_customer_iface extends base_iface {
    
    public function info_action () {
        $this->data['pc_nick'] = $this->data['pc_nick'] ? filter::char($this->data['pc_nick']) : '';
        $this->data['pc_area'] = $this->data['pc_area'] ? filter::int($this->data['pc_area']) : 0;
        $this->data['pc_room0'] = $this->data['pc_room0'] ? filter::int($this->data['pc_room0']) : 0;
        $this->data['pc_room1'] = $this->data['pc_room1'] ? filter::int($this->data['pc_room1']) : 0;
        $this->data['pc_room2'] = $this->data['pc_room2'] ? filter::int($this->data['pc_room2']) : 0;
        $this->data['pc_room3'] = 1;
        $this->data['pc_local'] = $this->data['pc_local'] ? filter::char($this->data['pc_local']) : '';
        $this->data['pc_sn'] = misc::randstr(8);
        $this->data['pc_status'] = 0;
        $this->data['pc_adm_id'] = 0;
        $this->data['pc_adm_nick'] = '';
        $this->data['pc_atime'] = REQUEST_TIME;
        $this->data['pc_utime'] = REQUEST_TIME;
        $this->data['pc_via'] = 0;
        $this->data['pc_status_del'] = 0;
        $this->data['pc_region0'] = 0;
        $this->data['pc_region1'] = 0;
        $this->data['pc_region2'] = 0;
        $this->data['pc_addr'] = '';
        $this->data['pc_co_id'] = 0;
        $this->data['pc_gender'] = 0;
        $this->data['pc_memo'] = $this->data['pc_local'] . '@' . $this->data['pc_area'] . '@' . $this->data['pc_room0']
            . '@' . $this->data['pc_room1'] . '@' . $this->data['pc_room2'] . '@' . $this->data['pc_room3'];
        $this->data['pc_score'] = 0;
        $this->verify([
            'pc_mobile' => [
                'code' => 101,
                'msg'  => '请输入正确的手机号',
                'rule' => filter::$rules['mobile'],
            ],
        ]);
        $tab = OBJ('customer_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc(), 102);
    }
    
}