<?php
namespace re\rgx;

class public_store_user_invoice_iface extends ubase_iface {
    
    public function get_action () {
        $id = intval($this->data['in_id']);
        $arr    = [];
        $arr['row'] = OBJ('invoice_table')->map(function ($row) {
            $regions    = OBJ('region_table')->akey('region_code')->get_all([
                'region_code'   => [$row['in_region0'], $row['in_region1'], $row['in_region2']]
            ]);
            $row['in_region0_lab']  = $regions[$row['in_region0']] ? $regions[$row['in_region0']]['region_name'] : '';
            $row['in_region1_lab']  = $regions[$row['in_region1']] ? $regions[$row['in_region1']]['region_name'] : '';
            $row['in_region2_lab']  = $regions[$row['in_region2']] ? $regions[$row['in_region2']]['region_name'] : '';
            return $row;
        })->get($id) ?: null;
        $arr['in_type_arr'] = store_user_invoice_helper::$in_type;
        $arr['in_title_type_arr']   = store_user_invoice_helper::$in_title_type;
        $arr['in_status_arr']   = store_user_invoice_helper::$in_status;
        $this->success('操作成功', $arr);
    }
    
    public function list_action () {
        
        //@todo 当前登录用户id
        $id = intval($this->data['pc_id']);
        
        $tab    = OBJ('invoice_table');
        $paging = new paging_helper($tab, $this->data['pn'], 12);
        $ret    = $tab->map(function ($row) {
            $row['in_type_lab'] = store_user_invoice_helper::$in_type[$row['in_type']];
            $row['in_title_type_lab']   = store_user_invoice_helper::$in_title_type[$row['in_title_type']];
            $regions    = OBJ('region_table')->akey('region_code')->get_all([
                'region_code'   => [$row['in_region0'], $row['in_region1'], $row['in_region2']]
            ]);
            $row['in_region0_lab']  = $regions[$row['in_region0']] ? $regions[$row['in_region0']]['region_name'] : '';
            $row['in_region1_lab']  = $regions[$row['in_region1']] ? $regions[$row['in_region1']]['region_name'] : '';
            $row['in_region2_lab']  = $regions[$row['in_region2']] ? $regions[$row['in_region2']]['region_name'] : '';
            $row['in_status_lab']   = store_user_invoice_helper::$in_status[$row['in_status']];
            return $row;
        })->order('in_atime desc')->get_all();
        $this->success('请求成功', [
            'list'  => array_values($ret),
            'paging'    => $paging->to_array(),
        ]);
    }
    
    public function save_action () {
        //个人 企业
        $this->data['in_id']   = intval($this->data['in_id']);
        $this->data['in_type'] = filter::normal($this->data['in_type']);
        $this->data['in_title_type']   = intval($this->data['in_title_type']);
        $this->data['in_title_name']   = filter::normal($this->data['in_title_name']);
        $this->data['in_content']  = '明细';
        $this->data['in_money']    = filter::float($this->data['in_money']);
        
        //@todo 通过当前登录用户获取用户信息
        //$this->data['pc_region0']
        $this->data['in_pc_id']    = $this->login['admin_id'];
        $this->data['in_receiver'] = filter::normal($this->data['in_receiver']) ?: $this->login['admin_account'];
        $this->data['in_mobile']   = filter::int($this->data['in_mobile']) ?: $this->login['admin_mobile'];
        $this->data['in_email']    = filter::normal($this->data['in_email']) ?: $this->login['admin_email'];
        $this->data['in_region0']  = filter::int($this->data['in_region0']) ?: 110000;
        $this->data['in_region1']  = filter::int($this->data['in_region1']) ?: 110100;
        $this->data['in_region2']  = filter::int($this->data['in_region2']) ?: 110111;
        $this->data['in_address']  = filter::normal($this->data['in_address']) ?: '填充假数据';
    
        $this->data['in_atime'] = $this->data['in_atime'] ?: REQUEST_TIME;
        $this->data['in_utime'] = REQUEST_TIME;
        $this->data['in_status']   = $this->data['in_status'] ?: store_user_invoice_helper::APPLY_STATUS;
        $tab    = OBJ('invoice_table');
        if ($this->data['in_title_type'] === 2) {
            //企业
            $this->data['in_sid']  = filter::normal($this->data['in_sid']);
            $this->data['in_addr'] = filter::normal($this->data['in_addr']);
            $this->data['in_dbank']    = filter::normal($this->data['in_dbank']);
            $this->data['in_anum'] = filter::normal($this->data['in_anum']);
            $this->verify([
                'in_type'   => [
                    'code'  => 101,
                    'msg'   => '发票类型不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_title_name' => [
                    'code'  => 102,
                    'msg'   => '发票抬头不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_sid'    => [
                    'code'  => 103,
                    'msg'   => '纳税人识别号不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_addr'   => [
                    'code'  => 104,
                    'msg'   => '公司注册地址不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_tel'    => [
                    'code'  => 105,
                    'msg'   => '请输入正确的固话号码',
                    'rule'  => filter::$rules['phone']
                ],
                'in_dbank'  => [
                    'code'  => 106,
                    'msg'   => '开户行不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_anum'   => [
                    'code'  => 107,
                    'msg'   => '银行账号不能为空',
                    'rule'  => function ($v) {
                        return !empty($v);
                    }
                ],
                'in_receiver'   => [
                    'code'  => 108,
                    'msg'   => '请输入正确的收件人',
                    'rule'  => function ($v) {
                        return filter::is_account($v);
                    }
                ],
                'in_mobile' => [
                    'code'  => 109,
                    'msg'   => '请输入正确的收货人手机号',
                    'rule'  => filter::$rules['mobile']
                ],
                'in_email'  => [
                    'code'  => 110,
                    'msg'   => '请输入正确的邮箱',
                    'rule'  => filter::$rules['email']
                ],
            ]);
        }
        //个人
        else {
            $this->data['in_sid']   = '';
            $this->data['in_addr']  = '';
            $this->data['in_tel']   = '';
            $this->data['in_dbank'] = '';
            $this->data['in_anum']  = '';
        }
        if ($tab->load($this->data)) {
            $ret    = $tab->save();
            if ($ret['rows'] === 1) {
                admin_helper::add_log($this->login['admin_id'], 'public/store/user/invoice', 2,
                    ($this->data['in_id'] ? '发票信息修改[' . $this->data['in_id'] :
                        '发票信息新增[' . $ret['row_id']) . '@' . $this->data['in_title_name'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }
    
    public function del_action () {
        $id = intval($this->data['in_id']);
        if (OBJ('invoice_table')->delete(['in_id' => $id])['rows'] === 1) {
            //@todo 删除日志...
            admin_helper::add_log($this->login['admin_id'], 'public/store/user/del', 1, '删除发票信息[@]');
            $this->success('操作成功');
        }
        $this->failure('操作失败');
    }
}
