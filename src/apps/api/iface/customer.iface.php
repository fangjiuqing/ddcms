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
<<<<<<< HEAD
        $pco = OBJ('community_table')->fields('pco_id, pco_name')->get($ret['pc_co_id']);
        $ret['pc_co_name'] = $pco['pco_name'];
        $this->success('操作成功', $ret);
=======
        $pco = OBJ('community_table')->get_all();
        $ret['pc_co_name'] = $pco[$ret['pc_co_id']]['pco_name'];
        $this->success('操作成功', [
            'ret' => $ret,
            'pco' => $pco,
        ]);
>>>>>>> 388a6e889d6a3fbdccc93a830d979f4249189273
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
        $this->data['pc_id'] = intval($this->data['id']);
        $this->data['pc_sn'] = filter::text($this->data['pc_sn']);
        $this->data['pc_sid'] = filter::int($this->data['sid']);
        $this->data['pc_nick'] = filter::char($this->data['pc_nick']);
        $this->data['pc_status'] = filter::int($this->data['pc_status']);
        $this->data['pc_adm_id'] = $this->login['admin_id'];
        $this->data['pc_adm_nick'] = $this->login['admin_account'];
        $this->data['pc_atime'] = (int)$this->data['pc_atime'] ?: REQUEST_TIME;
        $this->data['pc_utime'] = REQUEST_TIME;
        $this->data['pc_via'] = filter::int($this->data['pc_via']);
        $this->data['pc_status_del'] = filter::int($this->data['pc_status_del']);
        $this->data['pc_region0'] = filter::int($this->data['pc_region0']);
        $this->data['pc_region1'] = filter::int($this->data['pc_region1']);
        $this->data['pc_region2'] = filter::int($this->data['pc_region2']);
        $this->data['pc_addr'] = filter::text($this->data['pc_addr']);
        $this->data['pc_co_id'] = filter::int($this->data['pc_co_id']);
        $this->data['pc_gender'] = filter::int($this->data['pc_gender']);
        $this->data['pc_memo'] = filter::text($this->data['pc_memo']);
        $this->data['pc_score'] = filter::int($this->data['pc_score']);
        $this->verify([
            'pc_mobile' => [
                'code' => 100,
                'msg'  => '请输入合法的客户编号',
                'rule' => filter::$rules['phone'],
            ],
        ]);
        $ret = OBJ('customer_table')->update($this->data);
        if ($ret['rows']) {
            admin_helper::add_log($this->login['admin_id'], 'customer/save', '2',
                '修改用户信息[' . $this->data['pc_id'] . '@' . ']');
            $this->success('修改用户信息成功');
        }
        $this->failure('修改用户信息失败');
    }
    
}