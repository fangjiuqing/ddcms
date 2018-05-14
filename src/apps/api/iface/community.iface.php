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
        $num = intval($this->data['num']);
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, $num ?: 12);
        $pco_ids = [];
        $region0 = [];
        $region1 = [];
        $region2 = [];
        $region_tab = OBJ('region_table');
        $arts = $tab->map(function ($row) use (&$pco_ids, &$region0, &$region1, &$region2) {
            $pco_ids[$row['pco_id']] = 1;
            $region0[$row['pco_region0'] . '0000'] = 1;
            $region1[$row['pco_region1'] . '00'] = 1;
            $region2[$row['pco_region2']] = 1;
            return $row;
        })->get_all();
        $pco_list = OBJ('unit_copy_table')->get_all([
            'pu_co_id' => array_keys($pco_ids),
        ]);
        $img_list = [];
        foreach ((array)$pco_list as $k => $v) {
            $img_list[$v['pu_co_id']][] = IMAGE_URL . $v['pu_cover'];
        }
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
            $arts[$k]['pco_cover_label'] = isset($img_list[$v['pco_id']]) ?
                array_slice($img_list[$v['pco_id']], 0, 5) : '';
            $arts[$k]['pco_region0_label'] = isset($region0_list[$v['pco_region0'] . '0000']) ?
                $region0_list[$v['pco_region0'] . '0000']['region_name'] : '';
            $arts[$k]['pco_region1_label'] = isset($region1_list[$v['pco_region1'] . '00']) ?
                $region1_list[$v['pco_region1'] . '00']['region_name'] : '';
            $arts[$k]['pco_region2_label'] = isset($region2_list[$v['pco_region2']]) ?
                $region2_list[$v['pco_region2']]['region_name'] : '';
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
        
        $temp_list = OBJ('unit_copy_table')->get_all([
            'pu_co_id' => $id,
        ]);
        $unit_list = [];
        foreach ((array)$temp_list as $k => $v) {
            $v['pu_cover_thumb'] = IMAGE_URL . $v['pu_cover'];
            unset($v['pu_cover']);
            $unit_list[] = $v;
        }
        $this->success('操作成功', [
            'detail' => $ret,
            'list'   => array_values($unit_list),
        ]);
    }
    
    public function save_action () {
        var_dump($this->data);
        $this->data['base']['pco_id'] = intval($this->data['base']['pco_id']);
        $this->data['base']['pco_region0'] = (int)substr($this->data['base']['pco_region0'], 0, 2);
        $this->data['base']['pco_region1'] = (int)substr($this->data['base']['pco_region1'], 0, 4);
        $this->data['base']['pco_region2'] = (int)substr($this->data['base']['pco_region2'], 0, 6);
        if (empty($this->data['base']['pco_name'])) {
            $this->failure('请输入正确的小区名');
        }
        $this->data['base']['pco_addr'] = $this->data['base']['pco_addr'] ?: '';
        $community_tab = OBJ('community_copy_table');
        if ($community_tab->load($this->data['base'])) {
            $community_ret = $community_tab->save();
            if ($community_ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'community/save', '2',
                    ($this->data['base']['pco_id'] ? '小区编辑[' . $this->data['base']['pco_id'] :
                        '小区新增[' . $community_ret['row_id']) . '@]');
            }
        }
        if (!empty($this->data['add'])) {
            $unit_tab = OBJ('unit_copy_table');
            foreach ((array)$this->data['add'] as $v) {
                $v['pu_co_id'] = empty($this->data['base']['pco_id']) ?
                    $community_ret['row_id'] : $this->data['base']['pco_id'];
                if (empty($v['pu_area0']) || empty($v['pu_area1']) || $v['pu_area0'] <=
                    $v['pu_area1']) {
                    $this->failure('户型面积有误', 101);
                }
                switch ($v['pu_area0']) {
                    case $v['pu_area0'] <= 60 :
                        $v['pu_area_range'] = core_helper::RANGE_60;
                        break;
                    case $v['pu_area0'] <= 80 :
                        $v['pu_area_range'] = core_helper::RANGE_80;
                        break;
                    case $v['pu_area0'] <= 100 :
                        $v['pu_area_range'] = core_helper::RANGE_100;
                        break;
                    case $v['pu_area0'] <= 120 :
                        $v['pu_area_range'] = core_helper::RANGE_120;
                        break;
                    case $v['pu_area0'] <= 150 :
                        $v['pu_area_range'] = core_helper::RANGE_150;
                        break;
                    default :
                        $v['pu_area_range'] = core_helper::RANGE_MAX;
                        break;
                }
                if ($unit_tab->load($v)) {
                    $unit_ret = $unit_tab->save();
                    if ($unit_ret['code'] !== 0) {
                        $this->failure($unit_tab->get_error_desc(), 102);
                    }
                    admin_helper::add_log($this->login['admin_id'], 'community/save',
                        '2', '户型新增[' . $unit_ret['row_id'] . '@]');
                }
            }
        }
        if ($community_ret['code'] === 0) {
            $this->success('操作成功');
        }
        $this->failure($community_tab->get_error_desc(), 103);
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