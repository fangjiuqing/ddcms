<?php
namespace re\rgx;

/**
 * Class unit
 * @package re\rgx
 * anthor Fox
 */
class unit_iface extends ubase_iface {
    
    public function list_action () {
        $id = intval($this->data['id']);
        $unit_tab = OBJ('unit_copy_table');
        $paging = new paging_helper($unit_tab, $this->data['pn'] ?: 1, 4);
        $pu_list = $unit_tab->get_all([
            'pu_co_id' => $id,
        ]);
        foreach ((array)$pu_list as $k => $v) {
            $pu_list[$k]['pu_cover_thumb'] = IMAGE_URL . $v['pu_cover'] . '!500x309';
        }
        $this->success('操作成功', [
            'list'      => array_values($pu_list),
            'paging'    => $paging->to_array(),
        ]);
    }
    
    public function get_action () {
        $id = intval($this->data['id']);
        $ret = OBJ('unit_copy_table')->get($id);
        if (!$ret) {
            $this->failure('该户型不存在');
        }
        $ret['pu_cover_thumb'] = IMAGE_URL . $ret['pu_cover'] . '!500x309';
        $this->success('操作成功', $ret);
    }
    
    public function save_action () {
        $this->data['pu_id'] = intval($this->data['pu_id']);
        if (empty($this->data['pu_area0']) || empty($this->data['pu_area1']) || $this->data['pu_area0'] <
            $this->data['pu_area1']) {
            $this->failure('户型面积有误');
        }
        if ($this->data['pu_area0'] <= 60) {
            $this->data['pu_area_range'] = core_helper::RANGE_60;
        }
        elseif ($this->data['pu_area0'] <= 80) {
            $this->data['pu_area_range'] = core_helper::RANGE_80;
        }
        elseif ($this->data['pu_area0'] <= 100) {
            $this->data['pu_area_range'] = core_helper::RANGE_100;
        }
        elseif ($this->data['pu_area0'] <= 120) {
            $this->data['pu_area_range'] = core_helper::RANGE_120;
        }
        elseif ($this->data['pu_area0'] <= 150) {
            $this->data['pu_area_range'] = core_helper::RANGE_150;
        }
        else {
            $this->data['pu_area_range'] = core_helper::RANGE_MAX;
        }
        $tab = OBJ('unit_copy_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'unit/save', '2',
                    ($this->data['pu_id'] ? '户型编辑[' . $this->data['pu_id'] : '户型新增[' . $ret['row_id']) . '@]');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }
    
}