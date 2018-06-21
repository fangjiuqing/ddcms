<?php
namespace re\rgx;

/**
 * 设计师案例操作接口
 */
class designer_case_iface extends ubase_iface {

    /**
     * 获取可设置的案例列表
     * @return [type] [description]
     */
    public function list_action () {
        $des  = OBJ('designer_table')->fields('des_id,des_name')->get((int)$this->data['id']);
        $case = OBJ('case_table')->akey('case_id')->fields([
            'case_id', 'case_title', 'case_is_primary', 'case_designer_id', 'case_cover',
        ])->order('case_id desc')->map(function ($row) {
            $row['case_cover']  = IMAGE_URL . $row['case_cover'] . '!500x309';
            $row['case_is_primary'] = $row['case_is_primary'] ? true : false;
            return $row;
        })->get_all([
            'case_designer_id'  => (int)$this->data['id']
        ]);
        $this->success('', [
            'des'   => $des,
            'list'  => $case
        ]);
    }

    /**
     * 设置代表作
     */
    public function set_action () {
        $sets = [
            'checks'    => [],
            'unchecks'  => []
        ];
        $des_id = 0;
        foreach ((array)$this->data['rows'] as $k => $v) {
            if ($v['case_is_primary']) {
                $sets['checks'][] = $v['case_id'];
            }
            else {
                $sets['unchecks'][] = $v['case_id'];
            }
            $des_id = $des_id ?: $v['case_designer_id'];
        }
        $tab = OBJ('case_table');
        $tab->where("case_designer_id = {$des_id}")->update([
            'case_id'           => $sets['checks'] ?: [0],
            'case_is_primary'   => 1
        ]);
        $tab->where("case_designer_id = {$des_id}")->update([
            'case_id'           => $sets['unchecks'] ?: [0],
            'case_is_primary'   => 0
        ]);
        $this->success('更新成功');
    }
}
