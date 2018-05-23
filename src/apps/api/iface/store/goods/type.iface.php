<?php
namespace re\rgx;

/**
 * 商品类型管理
 */
class store_goods_type_iface extends ubase_iface {

    /**
     * 获取记录
     * @return [type] [description]
     */
    public function get_action () {
        $this->success('', [
            'row'   => OBJ('goods_type_table')->get((int)$this->data['id']) ?: null,
            'mtype' => material_helper::$type
        ]);
    }

    /**
     * 商品类型保存
     * @return [type] [description]
     */
    public function save_action () {
        $this->verify([
            'gt_name' => [
                'code' => '101',
                'msg'  => '请输入商品类型名称',
                'rule' => filter::$rules['require']
            ],
            'gt_type' => [
                'code' => '101',
                'msg'  => '请选择所属类别',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_int']
            ],
        ]);
        $tab = OBJ('goods_type_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 获取商品列表
     * @return [type] [description]
     */
    public function list_action () {
        $tab = OBJ('goods_type_table');
        $pobj = new paging_helper($tab, $this->data['pn'], 16);
        $this->success('', [
            'rows'  => $tab->order('gt_id asc')->get_all(),
            'mtype' => material_helper::$type
        ]);
    }

    /**
     * 删除接口
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('goods_type_table');
        $ret = $tab->get($id);
        if (!$ret) {
            $this->failure('该记录不存在');
        }
        if ($tab->delete(['gt_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'store/goods/type/del', '3',
                '删除商品类型[' . $id . '@' . $ret['gt_name'] . ']');
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }
}
