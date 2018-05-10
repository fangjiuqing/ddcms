<?php
namespace re\rgx;

/**
 * 小区/户型操作类
 * Class community_iface
 * @package re\rgx
 * anthor Fox
 */
class community_iface extends ubase_iface {
    
    /**
     * author Fox
     */
    public function list_action () {
        $tab = OBJ('community_copy_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 10);
        $region0 = [];
        $region1 = [];
        $region2 = [];
        $region_tab = OBJ('region_table');
        $arts = $tab->map(function ($row) use (&$region0, &$region1, &$region2) {
            $region0[$row['pco_region0'] . '0000']  = 1;
            $region1[$row['pco_region1'] . '00']    = 1;
            $region2[$row['pco_region2']]           = 1;
            return $row;
        })->get_all();
        $region0_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region0),
        ]);
        $region1_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region1),
        ]);
        $region2_list = $region_tab->akey('region_code')->get_all([
            'region_code' => array_keys($region2),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['pco_region0_label'] = isset($arts[$k]['pco_region0']) ?
                $region0_list[$arts[$k]['pco_region0'] . '0000']['region_name'] : '';
            $arts[$k]['pco_region1_label'] = isset($arts[$k]['pco_region1']) ?
                $region1_list[$arts[$k]['pco_region1'] . '00']['region_name'] : '';
            $arts[$k]['pco_region2_label'] = isset($arts[$k]['pco_region2']) ?
                $region2_list[$arts[$k]['pco_region2']]['region_name'] : '';
        }
        $this->success('查询成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * author Fox
     */
    public function get_action () {
        $id = (int)$this->data['id'];
        $ret = OBJ('community_copy_table')->get($id);
        if (!$ret) {
            $this->failure('该小区不存在');
        }
        $tab = OBJ('region_table');
        $region0_list = $tab->get([
            "region_code" => $ret['pco_region0'] . '0000',
        ]);
        $region1_list = $tab->get([
            "region_code" => $ret['pco_region1'] . '00',
        ]);
        $region2_list = $tab->get([
            "region_code" => $ret['pco_region2'],
        ]);
        $ret['region0_label'] = $region0_list['region_name'];
        $ret['region1_label'] = $region1_list ? $region1_list['region_name'] : '';
        $ret['region2_label'] = $region2_list ? $region2_list['region_name'] : '';
        $this->success('操作成功', $ret);
    }
    
    public function save_action () {
        $this->data['pco_id'] = intval($this->data['id']);
        $tab = OBJ('community_copy_table');
        $this->data['pco_region0'] = (int)substr($this->data['pco_region0'], 0, 2);
        $this->data['pco_region1'] = (int)substr($this->data['pco_region1'], 0, 4);
        $this->data['pco_region2'] = (int)substr($this->data['pco_region2'], 0, 6);
        if (empty($this->data['pco_name'])) {
            $this->failure('请输入正确的小区名');
        }
        $this->data['pco_addr'] = $this->data['pco_addr'] ?: '';
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'community/save',
                    '2', ($this->data['pco_id'] ? '小区编辑[' . $this->data['pco_id'] : '小区新增[' . $ret['row_id'])
                    . '@]');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }
    
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('community_copy_table');
        if (!$ret = $tab->get($id)) {
            $this->failure('删除的小区不存在');
        }
        if ($tab->delete(['pco_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'community/del', '3', '删除小区[' . $id . '@]');
            OBJ('unit_copy_table')->delete(['pu_co_id' => $id]);
            $this->success('删除小区成功');
        }
    }
    
}