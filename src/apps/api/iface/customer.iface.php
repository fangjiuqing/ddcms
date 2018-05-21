<?php
namespace re\rgx;

/**
 * 顾客操作类
 */
class customer_iface extends ubase_iface {
    
    /**
     * 获取顾客列表接口
     */
    public function list_action () {
        $tab = OBJ('customer_table');
        $tab->where(['pc_status_del' => 0]);
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $region_ids = [];
        $area_ids = [];
        $arts = $tab->map(function ($row) use (&$region_ids, &$area_ids) {
            $region_ids[$row['pc_region0']] = 1;
            $region_ids[$row['pc_region1']] = 1;
            $region_ids[$row['pc_region2']] = 1;
            $area_ids[$row['pc_co_id']] = 1;
            $row['via'] = core_helper::$customer_via[$row['pc_via']] ?: '未知';
            $row['status'] = core_helper::$customer_status[$row['pc_status']];
            $row['status_style'] = ['', 'text-primary', 'text-info', 'text-success', 'text-rose'][$row['pc_status']];
            $row['gender'] = ['', '先生', '女士'][$row['pc_gender']];
            return $row;
        })->order('pc_utime desc')->get_all();
        $region_list = OBJ('region_table')->akey('region_code')->get_all([
            'region_code' => array_keys($region_ids ?: [0]),
        ]);
        $area_list = OBJ('community_table')->akey('pco_id')->get_all([
            'pco_id' => array_keys($area_ids ?: [0]),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['pc_region0_label'] = isset($region_list[$v['pc_region0']]) ?
                $region_list[$v['pc_region0']]['region_name'] : '';
            $arts[$k]['pc_region1_label'] = isset($region_list[$v['pc_region1']]) ?
                $region_list[$v['pc_region1']]['region_name'] : '';
            $arts[$k]['pc_region2_label'] = isset($region_list[$v['pc_region2']]) ?
                $region_list[$v['pc_region2']]['region_name'] : '';
            $arts[$k]['pc_area'] = isset($area_list[$v['pc_co_id']]) ? $area_list[$v['pc_co_id']]['pco_name'] : '';
        }
        $this->success('获取列表成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * 删除顾客信息
     * @param int $id 被删除顾客id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('customer_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('要删除的用户信息不存在');
        }
        $this->data['pc_id'] = $id;
        $this->data['pc_status_del'] = 1;
        $result = $tab->update($this->data);
        if ($result['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'customer/del', '3',
                '删除顾客信息成功[' . $id . '@]');
            $this->success('删除成功');
        }
        admin_helper::add_log($this->login['admin_id'], 'customer/del', '3',
            '删除顾客信息失败[' . $id . '@]');
        $this->failure('删除失败', '101');
    }
    
    /**
     * 单条用户信息获取接口
     * @param int $id 用户ID
     */
    public function get_action () {
        $ret['row'] = OBJ('customer_table')->map(function ($row) {
            $regions = OBJ('region_table')->akey('region_code')->get_all([
                'region_code' => [$row['pc_region0'] ?: 0, $row['pc_region1'] ?: 0, $row['pc_region2'] ?: 0],
            ]);
            $row['region0'] = $regions[$row['pc_region0']]['region_name'] ?: '';
            $row['region1'] = $regions[$row['pc_region1']]['region_name'] ?: '';
            $row['region2'] = $regions[$row['pc_region2']]['region_name'] ?: '';
            return $row;
        })->left_join('customer_house_table', 'pch_pc_id', (int)$this->data['id'])
            ->left_join('community_table', 'pco_id', intval(OBJ('customer_table')
                ->get((int)$this->data['id'])['pc_co_id']))
            ->get((int)$this->data['id']) ?: null;
        if (empty($ret['row'])) {
            $this->failure('该客户不存在');
        }
        $ret['type'] = core_helper::$order_type;
        $ret['status'] = core_helper::$customer_status;
        $ret['via'] = core_helper::$customer_via;
        $this->success('操作成功', $ret);
    }
    
    /**
     * 客户信息保存
     * @return [type] [description]
     */
    public function save_action () {
        // 更新字段: 姓名,身份证,所在地, 小区, 地址, 性别, 备注, 所属客服, 更新时间
        // 更新先查询出记录. 若无所属客服, 则更新所属客服字段. 否则不更新所属客服
        $this->data['pc_sn'] = filter::char($this->data['pc_sn']) ?: date('YmdHis', app::get_time());
        if (!filter::is_account($this->data['pc_nick'])) {
            $this->failure('请输入正确的用户名');
        }
        $this->data['pc_status'] = filter::int($this->data['pc_status']) ?: 1;
        $this->data['pc_adm_id'] = isset($this->data['pc_adm_id']) ?
        (int)$this->data['pc_adm_id'] : $this->login['admin_id'];
        $this->data['pc_adm_nick'] = isset($this->data['pc_adm_nick']) ?
            $this->data['pc_adm_nick'] : $this->login['admin_account'];
        $this->data['pc_atime'] = (int)$this->data['pc_atime'] ?: REQUEST_TIME;
        $this->data['pc_utime'] = REQUEST_TIME;
        $this->data['pc_via'] = filter::int($this->data['pc_via']);
        $this->data['pc_status_del'] = filter::int($this->data['pc_status_del']);
        $this->data['pc_region0'] = filter::int($this->data['pc_region0']);
        $this->data['pc_region1'] = filter::int($this->data['pc_region1']);
        $this->data['pc_region2'] = filter::int($this->data['pc_region2']);
        $this->data['pc_addr'] = filter::normal($this->data['pc_addr']);
        $this->data['pc_co_id'] = filter::int($this->data['pc_co_id']);
        $this->data['pc_gender'] = filter::int($this->data['pc_gender']);
        $this->data['pc_memo'] = filter::text($this->data['pc_memo']);
        $this->data['pc_score'] = filter::int($this->data['pc_score']);
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
                admin_helper::add_log($this->login['admin_id'], 'customer/save', '2',
                    '客户' . ($this->data['pc_id'] ? '修改[' . $this->data['pc_id'] : '新增[' . $ret['row_id']) . '@]');
                $this->data['pct_adm_id']   = $this->login['admin_id'];
                $this->data['pct_adm_nick'] = $this->login['admin_account'];
                $this->data['pct_cus_id']   = intval($this->data['pc_id']) ?: $ret['row_id'];
                $this->data['pct_memo']     = $this->data['pc_id'] ? '修改客户信息' : '后台新增客户';
                $this->data['pct_atime']    = REQUEST_TIME;
                OBJ('customer_trace_table')->insert($this->data);
                $this->data['pch_id']       = (int)$this->data['pch_id'];
                $this->data['pch_pc_id']    = (int)$this->data['pch_pc_id'] ?: $ret['row_id'];
                $this->data['pch_type']     = (int)$this->data['pch_type'];
                $this->data['pch_mode']     = (int)$this->data['pch_mode'];
                $this->data['pch_style']    = (int)$this->data['pch_style'];
                $this->data['pch_area']     = (int)$this->data['pch_area'];
                $this->data['pch_area_use'] = (int)$this->data['pch_area_use'];
                $this->data['pch_floor']    = (int)$this->data['pch_floor'];
                $this->data['pch_exists']   = (int)$this->data['pch_exists'];
                $this->data['pch_gtime']    = (int)$this->data['pch_gtime'];
                $this->data['pch_budget']    = number_format($this->data['pch_budget'], 2) ?: 0.00;
                $house_tab = OBJ('customer_house_table');
                $house_tab->load($this->data);
                $house_tab->save();
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc(), 102);
    }
    
}