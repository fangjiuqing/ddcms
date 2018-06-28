<?php
namespace re\rgx;

class public_store_home_iface extends base_iface {
    
    /**
     * 商城商品分类
     * @var int
     */
    public $type_id = 10;
    
    /**
     * 商城首页分类列表
     */
    public function list_action () {
        $out = array_values(category_helper::to_tree(OBJ('category_table')->order('cat_level asc, cat_sort desc')
            ->get_all([
                'cat_type'  => $this->type_id,
                'cat_level' => [0, 1],
            ])));
        $this->success('', $out);
    }
}
