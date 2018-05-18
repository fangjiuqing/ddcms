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
     * 获取小区和5张户型图列表
     */
    public function list_action () {
        $tab = OBJ('community_table');
        $num = intval($this->data['num']);
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, $num ?: 12);

        $regions = [];
        $coms = $tab->akey('pco_id')->map(function ($row) use (&$regions) {
            $regions[sprintf("%-'06s",$row['pco_region0'])] = 1;
            $regions[sprintf("%-'06s",$row['pco_region1'])] = 1;
            $regions[sprintf("%-'06s",$row['pco_region2'])] = 1;
            $row['units'] = [];
            return $row;
        })->get_all();

        // 获取户型信息
        OBJ('unit_table')->map(function ($row) use (&$coms) {
            $coms[$row['pu_co_id']]['units'][] = [
                'cover' => IMAGE_URL . $row['pu_cover'] . '!500x309',
                'name'  => "{$row['pu_area0']} m² - {$row['pu_room0']}室{$row['pu_room1']}厅{$row['pu_room3']}厨{$row['pu_room2']}卫"
            ];
            return null;
        })->get_all([
            'pu_co_id' => array_keys($coms) ?: [0],
        ]);

        // 获取地区信息
        $regions = OBJ('region_table')->akey('region_code')->get_all([
            'region_code'   => array_keys($regions) ?: ['0']
        ]);

        // 关联地区数据
        foreach ((array)$coms as $k => $v) {
            $coms[$k]['nums'] = count($coms[$k]['units']);
            if (count($v['units']) > 3) {
                $coms[$k]['units'] = array_slice($v['units'], 0, 3);
            }
            $coms[$k]['region0'] = $regions[sprintf("%-'06s",$v['pco_region0'])]['region_name'] ?: '';
            $coms[$k]['region1'] = $regions[sprintf("%-'06s",$v['pco_region1'])]['region_name'] ?: '';
            $coms[$k]['region2'] = $regions[sprintf("%-'06s",$v['pco_region2'])]['region_name'] ?: '';
        }

        $this->success('操作成功', [
            'list'   => array_values($coms),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * 获取小区详情和所属户型列表
     * @param int $id 小区id
     */
    public function get_action () {
        $id = (int)$this->data['id'];
        $ret = OBJ('community_table')->get($id);
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
        
        $temp_list = OBJ('unit_table')->get_all([
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
    
    /**
     * 小区和户型新增
     * @param int    $pco_id      小区id(可选
     * @param int    $pco_region0 小区省id
     * @param int    $pco_region1 小区市id
     * @param int    $pco_region2 小区县id
     * @param string $pco_name    小区名
     * @param string $pco_addr    小区详细地址
     *
     * @param string $pu_name     户型名称
     * @param int    $pu_area0    总面积
     * @param int    $pu_area1    可用面积
     * @param int    $pu_room0    几室
     * @param int    $pu_room1    几厅
     * @param int    $pu_room2    几卫
     * @param int    $pu_room3    几厨
     * @param string $pu_cover    户型图
     */
    public function save_action () {
        $this->data['base']['pco_id'] = intval($this->data['base']['pco_id']);
        $this->data['base']['pco_region0'] = (int)substr($this->data['base']['pco_region0'], 0, 2);
        $this->data['base']['pco_region1'] = (int)substr($this->data['base']['pco_region1'], 0, 4);
        $this->data['base']['pco_region2'] = (int)substr($this->data['base']['pco_region2'], 0, 6);
        if (empty($this->data['base']['pco_name'])) {
            $this->failure('请输入正确的小区名');
        }
        $this->data['base']['pco_addr'] = $this->data['base']['pco_addr'] ?: '';
        $community_tab = OBJ('community_table');
        if ($community_tab->load($this->data['base'])) {
            $community_ret = $community_tab->save();
            if ($community_ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'community/save', '2',
                    ($this->data['base']['pco_id'] ? '小区编辑[' . $this->data['base']['pco_id'] :
                        '小区新增[' . $community_ret['row_id']) . '@]');
            }
        }
        if (!empty($this->data['add'])) {
            $unit_tab = OBJ('unit_table');
            foreach ((array)$this->data['add'] as $v) {
                $v['pu_co_id'] = empty($this->data['base']['pco_id']) ?
                    $community_ret['row_id'] : $this->data['base']['pco_id'];
                if (empty($v['pu_area0']) || empty($v['pu_area1']) || $v['pu_area0'] <=
                    $v['pu_area1']) {
                    $this->failure('户型面积有误', 101);
                }
                $v['pu_room0'] = intval($v['pu_room0']);
                $v['pu_room1'] = intval($v['pu_room1']);
                $v['pu_room2'] = intval($v['pu_room2']);
                $v['pu_room3'] = intval($v['pu_room3']);
                if (empty($v['pu_cover'])) {
                    $this->failure('户型图有误', 102);
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
                        $this->failure($unit_tab->get_error_desc(), 103);
                    }
                    admin_helper::add_log($this->login['admin_id'], 'community/save',
                        '2', '户型新增[' . $unit_ret['row_id'] . '@]');
                }
            }
        }
        if ($community_ret['code'] === 0) {
            $this->success('操作成功');
        }
        $this->failure($community_tab->get_error_desc(), 104);
    }
    
    /**
     * 小区删除
     * @param int $id 要删除小区的id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('community_table');
        if (!$ret = $tab->get($id)) {
            $this->failure('删除的小区不存在');
        }
        $unit_tab = OBJ('unit_table');
        $unit_ret = $unit_tab->get_all(['pu_co_id' => $id]);
        foreach ((array)$unit_ret as $v) {
            if (upload_helper::is_upload_file($v['pu_cover'])) {
                unlink(UPLOAD_PATH . $v['pu_cover']);
            }
        }
        $unit_tab->delete(['pu_co_id' => $id]);
        if ($tab->delete(['pco_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'community/del', '3', '删除小区[' . $id . '@]');
            $this->success('删除小区成功');
        }
    }
    
}