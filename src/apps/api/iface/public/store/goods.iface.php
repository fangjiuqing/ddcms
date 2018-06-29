<?php
namespace re\rgx;

/**
 * 商品接口类
 * @todo
 */
class public_store_goods_iface extends base_iface {
    
    /**
     * 商城商品分类
     * @var int
     */
    public $type_id = 10;
    
    /**
     * 商品列表
     */
    public function list_action () {
        $cat_tab    = OBJ('category_table');
        $goods_tab  = OBJ('goods_table');
        $ret    = $cat_tab->map(function ($row) use($cat_tab, $goods_tab) {
            //收集大分类下的所有分类id, 展示首页商品
            $all_ids    = [];
            $all_ids[]  = $row['cat_id'];
            
            $row['nodes']   = $cat_tab->map(function ($row) use(&$all_ids, $cat_tab, $goods_tab) {
                //收集二级以下的分类id, 展示商品
                $son_ids    = [];
                $all_ids[]  = $row['cat_id'];
                $son_ids[]  = $row['cat_id'];
                
                $row['node']    = $cat_tab->map(function ($row) use (&$all_ids, &$son_ids, $goods_tab) {
                    $all_ids[]  = $row['cat_id'];
                    $son_ids[]  = $row['cat_id'];
                    //获取当前三级分类下的所有商品
                    $row['goods']   = $goods_tab->order('goods_cat_id asc, goods_stat_sale desc')->get_all([
                        'goods_cat_id' => $row['cat_id'],
                        'goods_status' => store_helper::GOODS_STATUS_ONSALE,
                    ]);
                    return $row;
                })->get_all(['cat_parent' => $row['cat_id']]);
                
                //获取当前二级(包括三级)分类下的所有商品
                $row['goods']   = $goods_tab->order('goods_cat_id asc, goods_stat_sale desc')->get_all([
                    'goods_cat_id'  => $son_ids,
                    'goods_status'  => store_helper::GOODS_STATUS_ONSALE,
                ]);
                return $row;
            })->get_all(['cat_parent' => $row['cat_id']]);
    
            //获取当前一级(二级, 三级)分类下的商品
            $row['goods']   = $goods_tab->order('goods_cat_id asc, goods_stat_sale desc')->limit(9)->map(function
            ($row) {
                $row['goods_cover'] = IMAGEURL . $row['goods_cover'] . '!500x309';
                return $row;
            })->get_all([
                'goods_cat_id'  => $all_ids,
                'goods_status'  => store_helper::GOODS_STATUS_ONSALE,
            ]);
            return $row;
        })->get_all(['cat_type'  => $this->type_id, 'cat_level' => 0]);
        $this->success('', $ret);
    }
}
