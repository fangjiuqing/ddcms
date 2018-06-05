<?php
namespace re\rgx;

/**
 * 商品管理接口
 */
class store_goods_iface extends ubase_iface {

    /**
     * 获取商品详情
     * @return [type] [description]
     */
    public function get_action () {
        $out = [
            'row'   => OBJ('goods_table')->get((int)$this->data['id']) ?: null
        ];
        $out['brands'] = OBJ('brand_table')->get_all() ?: null;
        $out['categories'] = category_helper::get_options(category_helper::TYPE_GOODS, 0, 0);
        $out['types'] = store_helper::get_goods_types(false, true);
        $this->success('', $out);
    }


}