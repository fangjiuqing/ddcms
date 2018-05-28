<?php
namespace re\rgx;

/**
 * 商品分类接口类
 * @author reginx
 */
class store_goods_category_iface extends category_iface {

    /**
     * 商城商品分类
     * @var integer
     */
    public $type_id = 10;


    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('category_table')->fields([
            'cat_id', 'cat_name', 'cat_parent', 'cat_type', 'cat_sort', 'cat_status', 'cat_extra'
        ])->get(
            (int)$this->data['id']
        );
        if ($this->data['parent']) {
            $out['parent_options'] = category_helper::get_options($this->type_id, 0, $this->data['id']);
            array_unshift($out['parent_options'], ['cat_id' => 0, 'cat_name' => '作为一级分类', 'cat_level' => 0]);
            foreach ((array)$out['parent_options'] as $k => $v) {
                $out['parent_options'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
            }
        }
        $out['cat_parent'] = intval($out['cat_parent']);
        $out['status_options'] = category_helper::$status;
        $out['type'] = OBJ('goods_type_table')->get_all();
        $this->success('', $out);
    }
}
