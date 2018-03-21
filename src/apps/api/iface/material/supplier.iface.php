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
        $out = OBJ('supplier_table')->map(function ($row) {
            $regions = OBJ('region_table')->akey('region_code')->get_all([
                $row['sup_region0'] ?: 0,
                $row['sup_region1'] ?: 0,
                $row['sup_region2'] ?: 0
            ]);
            $row['province'] = $regions[$row['sup_region0']] ? $regions[$row['sup_region0']]['region_name'] : '';
            $row['city'] = $regions[$row['sup_region1']] ? $regions[$row['sup_region1']]['region_name'] : '';
            $row['area'] = $regions[$row['sup_region2']] ? $regions[$row['sup_region2']]['region_name'] : '';
            return $row;
        })->get($this->data['id']);
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
        $this->data['sup_admin_id'] = $this->login['admin_id'];
        $this->data['sup_adate'] = REQUEST_TIME;
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'supplier/save', 1,
                    ($this->data['pb_id'] ? '编辑' : '新增') . '供应商[' . $this->data['sup_realname'] . ']'
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
        $sup = $tab->get($id);
        if (empty($sup)) {
            $this->failure('该供应商不存在');
        }
        // 删除
        if ($tab->delete(['sup_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'supplier/del', 1, '删除供应商 ID：' . $id);
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }

}
