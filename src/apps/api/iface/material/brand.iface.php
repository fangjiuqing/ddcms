<?php
namespace re\rgx;

/**
 * 品牌管理接口
 */
class material_brand_iface extends admin_iface {

    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('brand_table')->get($this->data['id']);
        if ($this->data['parent']) {
        }
        $out['cat_parent'] = intval($out['cat_parent']);
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
                $this->success('操作成功');
                admin_helper::add_log($this->login['admin_id'], 'brand/save', 1,
                    ($this->data['cat_id'] ? '编辑' : '新增') . '分类[' . $this->data['pb_name'] . ']'
                );
            }
        }
        $this->failure($tab->get_first_error());
    }

    /**
     * 列表
     */
    public function list_action () {
        $this->success('', []);
    }

    /**
     *  删除
     */
    public function del_action () {
        $id  = intval($this->data['id']);
        $tab = OBJ('brand_table');
        $cat = $tab->get($id);
        if (empty($cat)) {
            $this->failure('该分类不存在');
        }

        if ($tab->where([
                "cat_parent"    => $cat['cat_id']
            ])->count() > 0) {
            $this->failure('请先删除下属分类');
        }
        // 删除
        if ($tab->delete(['cat_id' => $id])['code'] === 0) {
            $this->success('删除成功');
            admin_helper::add_log($this->login['admin_id'], 'brand/del', 1, '删除分类，ID：' . $id);
        }
        $this->failure('请先删除子类别');
    }

}
