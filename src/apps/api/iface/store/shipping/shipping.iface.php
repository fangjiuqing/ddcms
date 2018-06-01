<?php
namespace re\rgx;

/**
 * 商品类型管理
 */
class store_shipping_shipping_iface extends ubase_iface {

    /**
     * 获取记录
     * @return [type] [description]
     */
    public function get_action () {
        $row   = OBJ('shipping_table')->get((int)$this->data['id']);
        $areas = json_decode($row['shipping_regions'] , true);
        $this->success('', [
            'row'     => $row ? : null,
            'areas'   => $areas ? : null,
        ]);
    }

    /**
     * 商品类型保存
     * @return [type] [description]
     */
    public function save_action () {
        $base  = $this->data['base'];
        $areas = $this->data['areas'];
        $this->verify([
            'shipping_name' => [
                'code' => '101',
                'msg'  => '请输入配送名称',
                'rule' => filter::$rules['require']
            ],
            'shipping_price' => [
                'code' => '101',
                'msg'  => '配送价格必须为正数',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_price']
            ],
            'shipping_free' => [
                'code' => '101',
                'msg'  => '免费额度必须为正数',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_price']
            ],
        ] , $base);

        if (empty($areas)) {
            $this->failure('区域不能为空！');
        }

        # 处理区域数据
        $base['shipping_regions'] = filter::json_ecsape($areas);

        $tab = OBJ('shipping_table');
        if ($tab->load($base)) {
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
        $tab = OBJ('shipping_table');
        $pobj = new paging_helper($tab, $this->data['pn'], 16);
        $this->success('', [
            'list'  => $tab->order('shipping_id asc')->get_all(),
            'paging'=> $pobj
        ]);
    }

    /**
     * 删除接口
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('shipping_table');
        $ret = $tab->get($id);
        if (!$ret) {
            $this->failure('该记录不存在');
        }
        if ($tab->delete(['shipping_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'store/shipping/shipping/del', '3',
                '删除配送方式[' . $id . '@' . $ret['shipping_name'] . ']');
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }
}
