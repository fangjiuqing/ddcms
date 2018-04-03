<?php
namespace re\rgx;

/**
 * 顾客操作类
 */
class customer_iface extends base_iface {
    
    /**
     * 获取顾客列表接口
     * @param string $uri          请求的接口
     * @param array  $data
     * @param string $access_token token
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
            return $row;
        })->get_all(['pc_status_del' => 0]);
        $region_list = OBJ('region_table')->akey('region_code')->get_all([
            'region_code' => array_keys($region_ids ?: [0]),
        ]);
        $area_list = OBJ('community_table')->akey('pco_id')->get_all([
            'pco_id' => array_keys($area_ids ?: [0]),
        ]);
        foreach ($arts as $k => $v) {
            $arts[$k]['pc_region00'] = isset($region_list[$v['pc_region0']]) ?
                $region_list[$v['pc_region0']]['region_name'] : '';
            $arts[$k]['pc_region10'] = isset($region_list[$v['pc_region1']]) ?
                $region_list[$v['pc_region1']]['region_name'] : '';
            $arts[$k]['pc_region20'] = isset($region_list[$v['pc_region2']]) ?
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
     * @param array $data 被删除用户id
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
        $id = intval($this->data['id']);
        $ret = OBJ('customer_table')->get($id);
        if (!$ret) {
            $this->failure('该用户不存在');
        }
        $this->success('操作成功', $ret);
    }
    
    /**
     * 用户信息保存接口
     * @param int    $id            用户ID
     * @param int    $pc_sn         用户编号
     * @param int    $pc_sid        身份证号
     * @param string $pc_nick       用户名
     * @param int    $pc_mobile     手机号
     * @param int    $pc_status     用户状态
     * @param int    $pc_adm_id     用户所属客服ID
     * @param string $pc_adm_nick   用户所属客服姓名
     * @param int    $pc_atime      添加时间
     * @param int    $pc_via        客户来源
     * @param int    $pc_status_del 用户是否被删除
     * @param int    $pc_region0    省份
     * @param int    $pc_region1    市区
     * @param int    $pc_region2    县区
     * @param string $pc_addr       详细地址
     * @param int    $pc_co_id      所在小区
     * @param int    $pc_gender     性别
     * @param string $pc_memo       备注
     * @param int    $pc_score      成功率
     */
    public function save_action () {
        $this->data['pc_sn'] = filter::char($this->data['pc_sn']);
        $this->data['pc_nick'] = filter::char($this->data['pc_nick']);
        $this->data['pc_status'] = filter::int($this->data['pc_status']);
        $this->data['pc_adm_id'] = (int)$this->login['admin_id'];
        $this->data['pc_adm_nick'] = $this->login['admin_account'];
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
                'code' => 100,
                'msg'  => '请输入合法的手机号',
                'rule' => filter::$rules['mobile'],
            ],
            'pc_sid'    => [
                'code' => 101,
                'msg'  => '请输入正确的身份证号',
                'rule' => filter::$rules['cn_id'],
            ],
        ]);
        $tab = OBJ('customer_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'customer/save', '2',
                    '用户信息' . ($this->data['pc_id'] ? '修改[' . $this->data['pc_id'] : '新增[' . $ret['row_id']) . '@]');
                $this->success('操作成功');
            }
        }
        dump($tab->get_error());
        $this->failure('操作失败');
    }
    
}