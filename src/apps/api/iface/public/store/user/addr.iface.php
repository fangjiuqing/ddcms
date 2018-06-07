<?php
namespace re\rgx;

/**
 * @todo 用户地址接口类 (pre_user_addr)
 */
class public_store_user_addr_iface extends ubase_iface {


    /**
     * 收货地址列表
     */
    public function list_action () {
        $uid        = intval($this->data['id']);
        $tab   = OBJ('user_addr_table');
        $paging     = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $ret['row'] = OBJ('user_table')->get($uid);
        unset($ret['row']['pu_passwd']);
        unset($ret['row']['pu_salt']);
        $ret['list']    = $tab->map(function ($row) {
            $regions    = OBJ('region_table')->akey('region_code')->get_all([
                'region_code'   => [
                    $row['ua_region0'] ?: 0,
                    $row['ua_region1'] ?: 0,
                    $row['ua_region2'] ?: 0,
                    $row['ua_region3'] ?: 0
                ],
            ]);
            $row['ua_region0_label']    = $regions[$row['ua_region0']]['region_name'] ?: '';
            $row['ua_region1_label']    = $regions[$row['ua_region1']]['region_name'] ?: '';
            $row['ua_region2_label']    = $regions[$row['ua_region2']]['region_name'] ?: '';
            $row['ua_region3_label']    = $regions[$row['ua_region3']]['region_name'] ?: '';
            $row['ua_sort'] = $row['ua_sort'] == 255 ? '默认地址' : '';
            return $row;
        })->order('ua_sort desc')->get_all(['ua_user_id' => $uid]);
        $this->success('操作成功', [
            'row'       => $ret['row'],
            'list'      => $ret['list'],
            'pageing'   => $paging->to_array(),
        ]);
    }

    /**
     * 新增收货地址
     */
    public function save_action () {
        //数据处理
        $arr    = [];
        $arr['ua_name']     = filter::normal($this->data['ua_name']);
        $arr['ua_user_id']  = filter::int($this->data['id']);
        $arr['ua_consignee']    = filter::text($this->data['ua_consignee']);
        $arr['ua_email']    = filter::email($this->data['ua_email']);
        $arr['ua_region0']  = filter::int($this->data['ua_region0']);
        $arr['ua_region1']  = filter::int($this->data['ua_region1']);
        $arr['ua_region2']  = filter::int($this->data['ua_region2']);
        $arr['ua_region3']  = filter::int($this->data['ua_region3']);
        $arr['ua_addr']     = filter::normal($this->data['ua_addr']);
        $arr['ua_zipcode']  = filter::normal($this->data['ua_zipcode']);
        $arr['ua_mobile']   = filter::int($this->data['ua_mobile']);
        $arr['ua_sort']     = filter::int($this->data['ua_sort']);
        if (empty($arr['ua_name'])) {
            if (strpos($this->data['ua_region0_label'], '古')) {
                $region_label   = substr($this->data['ua_region0_label'], 0, 9);
            }
            elseif (strpos($this->data['ua_region0_label'], '江')) {
                $region_label   = substr($this->data['ua_region0_label'], 0, 9);
            }
            else {
                $region_label   = substr($this->data['ua_region0_label'], 0, 6);
            }
            $arr['ua_name'] = $arr['ua_consignee'] . '-' . $region_label;
        }
        $this->verify([
            'ua_mobile' => [
                'code'  => '101',
                'msg'   => '请输入正确的手机号',
                'rule'  => filter::$rules['mobile'],
            ],
            'ua_addr'   => [
                'code'  => '102',
                'msg'   => '请输入正确的地址',
                'rule'  => function ($v) {
                    return !empty($v);
                },
            ],
            'ua_region1'    => [
                'code'  => '103',
                'msg'   => '请输入正确的地址',
                'rule'  => function ($v) {
                    return !empty($v);
                },
            ],
        ]);
        $tab    = OBJ('user_addr_table');
        //数据对比
        $exist  = $tab->get_all(['ua_user_id' => $arr['ua_user_id']]);
        foreach ((array)$exist as $v) {
            $next   = $arr['ua_name'] . $arr['ua_user_id'] . $arr['ua_consignee'] . $arr['ua_email'] . $arr['ua_region0']
                . $arr['ua_region1'] . $arr['ua_region2'] . $arr['ua_region3'] . $arr['ua_addr'] . $arr['ua_mobile'];
            $prev   = $v['ua_name'] . $v['ua_user_id'] . $v['ua_consignee'] . $v['ua_email'] . $v['ua_region0']
                . $v['ua_region1'] . $v['ua_region2'] . $v['ua_region3'] . $v['ua_addr'] . $v['ua_mobile'];
            if ($next === $prev) {
                $this->success('操作成功');
            }
        }
        //数据保存
        if ($tab->load($arr)) {
            $ret    = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'public/store/user/addr/save', '2',
                    '新增收货地址[' . $ret['row_id'] . '@'. $arr['ua_name'] .']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 删除收货地址
     */
    public function del_action () {
        $id = intval($this->data['id']);
        if (OBJ('user_addr_table')->delete(['ua_id' => $id])['rows'] === 1) {
            admin_helper::add_log($this->login['admin_id'], 'public/store/user/addr/del', '3', '删除收货地址[' . $id . '@]');
            $this->success('操作成功');
        }
        $this->failure('操作失败');
    }
    
    /**
     * 默认收货地址设置
     */
    public function set_action () {
        $id = intval($this->data['id']);
        $ua_user_id    = intval($this->data['ua_user_id']);
        $tab    = OBJ('user_addr_table');
        $tab->where('ua_user_id = ' . $ua_user_id)->update(['ua_sort' => 0]);
        $tab->where('ua_id = ' . $id)->update(['ua_sort' => 255]);
        $this->success('操作成功');
    }
    
    /**
     * 收货地址详情
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $this->success('操作成功', OBJ('user_addr_table')->map(function ($row) {
            $regions    = OBJ('region_table')->akey('region_code')->get_all([
                'region_code'   => [
                    $row['ua_region0'] ?: 0,
                    $row['ua_region1'] ?: 0,
                    $row['ua_region2'] ?: 0,
                    $row['ua_region3'] ?: 0,
                ],
            ]);
            $row['ua_region0_label']    = $regions[$row['ua_region0']]['region_name'] ?: '';
            $row['ua_region1_label']    = $regions[$row['ua_region1']]['region_name'] ?: '';
            $row['ua_region2_label']    = $regions[$row['ua_region2']]['region_name'] ?: '';
            $row['ua_region3_label']    = $regions[$row['ua_region3']]['region_name'] ?: '';
            return $row;
        })->get($id));
    }
}
