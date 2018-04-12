<?php
namespace re\rgx;

/**
 * 品牌管理接口
 */
class material_brand_iface extends ubase_iface {

    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('brand_table')->get($this->data['id']);
        if ($this->data['attrs']) {
            $out['attrs']['supplier'] = OBJ('supplier_table')->fields('sup_id,sup_realname')->get_all();
        }
        $this->success('', $out);
    }

    /**
     * 添加分类接口
     */
    public function save_action () {
        $tab = OBJ('brand_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'brand/save', 1,
                    ($this->data['pb_id'] ? '编辑' : '新增') . '品牌[' . $this->data['pb_name'] . ']'
                );
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_first_error());
    }

    /**
     * 列表
     */
    public function list_action () {
        $supplier_ids = [];
        $out['list'] = OBJ('brand_table')->map(function ($row) use (&$supplier_ids) {
            $supplier_ids[$row['pb_sup_id']] = 0;
            return $row;
        })->get_all();
        $out['attrs']['paging'] = [];
        $out['attrs']['type'] = material_helper::$type;
        $out['attrs']['supplier'] = OBJ('supplier_table')->fields('sup_id,sup_realname')->akey('sup_id')->get_all([
            'sup_id'    => array_keys($supplier_ids ?: [0])
        ]);
        $this->success('', $out);
    }

    /**
     *  删除
     */
    public function del_action () {
        $id  = intval($this->data['id']);
        $tab = OBJ('brand_table');
        $cat = $tab->get($id);
        if (empty($cat)) {
            $this->failure('该品牌不存在');
        }
        // 删除
        if ($tab->delete(['pb_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'brand/del', 1, '删除分类，ID：' . $id);
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }

}
