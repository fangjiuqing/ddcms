<?php
namespace re\rgx;

/**
 * 品牌管理接口
 */
class material_supplier_iface extends admin_iface {

    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('supplier_table')->get($this->data['id']);
        if ($this->data['attrs']) {
            $out['attrs']['type'] = material_helper::$type;
        }
        $this->success('', $out);
    }

    /**
     * 添加分类接口
     */
    public function save_action () {
        $tab = OBJ('supplier_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'supplier/save', 1,
                    ($this->data['pb_id'] ? '编辑' : '新增') . '品牌[' . $this->data['pb_name'] . ']'
                );
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 列表
     */
    public function list_action () {
        $region_ids = [];
        $out['list'] = OBJ('supplier_table')->map(function ($row) use (&$region_ids) {
            $region_ids[$row['sup_region0']] = 0;
            $region_ids[$row['sup_region1']] = 0;
            $region_ids[$row['sup_region2']] = 0;
            return $row;
        })->get_all();
        $out['attrs']['paging'] = [];
        $out['attrs']['type'] = material_helper::$type;
        $out['attrs']['region'] = OBJ('region_table')->fields('region_code,region_name')->akey('region_code')->get_all([
            'region_code'   => array_keys($region_ids ?: [0])
        ]);
        $this->success('', $out);
    }

    /**
     *  删除
     */
    public function del_action () {
        $id  = intval($this->data['id']);
        $tab = OBJ('supplier_table');
        $cat = $tab->get($id);
        if (empty($cat)) {
            $this->failure('该品牌不存在');
        }
        // 删除
        if ($tab->delete(['pb_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'supplier/del', 1, '删除分类，ID：' . $id);
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }

}
