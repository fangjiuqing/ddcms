<?php
namespace re\rgx;

/**
 * 客户信息接口类
 */
class public_customer_iface extends base_iface {
    
    /**
     * pc客户预留手机号及信息接口
     * @param string  $pc_nick   用户名
     * @param integer $pc_area   总面积
     * @param int     $pc_room0  几室
     * @param int     $pc_room1  几厅
     * @param int     $pc_room2  几卫
     * @param string  $pc_local  所在小区
     * @param int     $pc_mobile 客户手机号
     * @param int     $pc_code   验证码
     */
    public function info_action () {
        $this->data['pc_nick'] = $this->data['pc_nick'] ? filter::char($this->data['pc_nick']) : '新客户';
        $this->data['pc_area'] = $this->data['pc_area'] ? filter::int($this->data['pc_area']) : 0;
        $this->data['pc_room0'] = $this->data['pc_room0'] ? filter::int($this->data['pc_room0']) : 0;
        $this->data['pc_room1'] = $this->data['pc_room1'] ? filter::int($this->data['pc_room1']) : 0;
        $this->data['pc_room2'] = $this->data['pc_room2'] ? filter::int($this->data['pc_room2']) : 0;
        $this->data['pc_room3'] = 1;
        $this->data['pc_local'] = $this->data['pc_local'] ? filter::char($this->data['pc_local']) : '';
        $this->data['pc_sn'] = date('YmdHis', app::get_time());
        $this->data['pc_status'] = 1;
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
        $this->data['pc_memo'] = '';
        $this->data['pc_score'] = 0;
        $this->verify([
            'pc_mobile' => [
                'code' => 101,
                'msg'  => '请输入正确的手机号。',
                'rule' => filter::$rules['mobile'],
            ],
        ]);
        $this->data['pc_code'] = intval($this->data['pc_code']);
        $result = OBJ('verify_table')->get([
            'verify_mobile' => $this->data['pc_mobile'],
            'verify_type'   => customer_helper::MOBILE_TYPE,
        ]);
        if (REQUEST_TIME - $result['verify_adate'] > 5 * 60) {
            $this->failure('验证码已失效。');
        }
        if ($this->data['pc_code'] != $result['verify_desc']) {
            $this->failure('验证码有误，请重试。', 102);
        }
        $tab = OBJ('customer_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $this->data['pch_pc_id']    = $ret['row_id'];
                $this->data['pch_type']     = 0;
                $this->data['pch_mode']     = 0;
                $this->data['pch_style']    = 0;
                $this->data['pch_area']     = (int)$this->data['pc_area'];
                $this->data['pch_area_use'] = 0;
                $this->data['pch_floor']    = 0;
                $this->data['pch_exists']   = 0;
                $this->data['pch_gtime']    = 0;
                $this->data['pch_budget']   = 0;
                OBJ('customer_house_table')->insert($this->data);
                admin_helper::add_log($this->login['admin_id'], 'public/customer/save', '2', '客户新增[' . $ret['row_id']
                    . '@]');
                $this->data['pct_adm_id']   = 0;
                $this->data['pct_adm_nick'] = '';
                $this->data['pct_cus_id']   = $ret['row_id'];
                $this->data['pct_memo']     = 'PC客户信息预留';
                $this->data['pct_atime']    = REQUEST_TIME;
                OBJ('customer_trace_table')->insert($this->data);
                $this->success('操作成功。');
            }
        }
        $this->failure($tab->get_error_desc(), 103);
    }
    
    /**
     * 根据手机号发送手机验证码
     * @param int $verify_mobile 接收验证码的手机号
     */
    public function code_action () {
        $this->verify([
            'verify_mobile' => [
                'code' => 100,
                'msg'  => '请输入正确的手机号',
                'rule' => filter::$rules['mobile'],
            ],
        ]);
        $this->data['verify_desc'] = mt_rand(1000, 9999);
        $this->data['verify_adate'] = REQUEST_TIME;
        if (OBJ('customer_table')->get([
            'pc_mobile' => $this->data['verify_mobile'],
        ])) {
            $this->failure('此号码已占用');
        }
        $tab = OBJ('verify_table');
        //验证是否为第二次发送短信
        $result = $tab->get([
            'verify_mobile' => $this->data['verify_mobile'],
            'verify_type'   => customer_helper::MOBILE_TYPE,
        ]);
        if ($result) {
            //同一号码5分钟之内不允许再次发送
            if (REQUEST_TIME - $result['verify_adate'] < 5 * 60) {
                $this->success('验证码已发送, 5分钟之内有效');
            }
            $tab->where([
                'verify_mobile' => $this->data['verify_mobile'],
                'verify_type'   => customer_helper::MOBILE_TYPE,
            ])->update($this->data);
            task_helper::send_verify($this->data['verify_mobile'], $this->data['verify_desc']);
            $this->success('操作成功');
        }
        
        //首次发送信息
        $this->data['verify_type'] = customer_helper::MOBILE_TYPE;
        $this->data['verify_user_id'] = 0;
        $this->data['verify_email'] = '';
        $this->data['verify_account'] = '';
        $ret = $tab->insert($this->data);
        if ($ret['row_id']) {
            task_helper::send_verify($this->data['verify_mobile'], $this->data['verify_desc']);
            $this->success('操作成功');
        }
        $this->failure('操作失败', 101);
    }
    
}