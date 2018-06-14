<?php
namespace re\rgx;

/**
 * 商品操作助手类
 */
class store_goods_helper extends rgx {

    public static $spec_status  = [
        1   => '已上架',
        2   => '已下架',
    ];
    const NS_STATUS = 1;
    
    /**
     * 删除商品
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    public static function remove ($goods_id, $remove_image = false) {
        $goods = OBJ('goods_table')->get($goods_id);
        if ($remove_image) {
            task_helper::del_file($goods['goods_cover']);
        }

        OBJ('goods_spec_table')->map(function ($row) use ($remove_image) {
            if ($remove_image) {
                task_helper::del_file($row['gs_cover']);
            }
            return null;
        })->get_all([
            'gs_goods_id'  => $goods_id
        ]);
        OBJ('goods_spec_attr_table')->delete([
            'gsa_goods_id'  => $goods_id
        ]);
        OBJ('goods_spec_table')->delete([
            'gs_goods_id'  => $goods_id
        ]);
        OBJ('goods_table')->delete([
            'goods_id'  => $goods_id
        ]);
    }

    /**
     * 获取商品的基本属性及规格
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    public static function get_base_attrs ($goods_id) {
        $ret = [];
        $attrs =  OBJ('goods_spec_attr_table')->get_all([
            'gsa_goods_id'  => $goods_id
        ]);
        return $ret;
    }

    /**
     * 添加商品基本属性
     * @param [type] $goods_id [description]
     * @param [type] $attrs    [description]
     */
    public static function add_base_attrs ($goods_id, $attrs) {
        $tab = OBJ('goods_spec_attr_table');
        // 清除已有的基本属性记录
        $tab->delete([
            'gsa_goods_id'  => $goods_id,
            'gsa_spec_id'   => 0,
            'gsa_type'      => 1
        ]);
        foreach ($attrs as $v) {
            $tab->insert($v);
        }
    }

    /**
     * 添加商品筛选属性
     * @param [type] $goods_id [description]
     * @param [type] $attrs    [description]
     */
    public static function add_filter_attrs ($goods_id, $spec_id, $attrs) {
        $tab = OBJ('goods_spec_attr_table');
        // 清除已有的基本属性记录
        $tab->delete([
            'gsa_goods_id'  => $goods_id,
            'gsa_spec_id'   => $spec_id,
            'gsa_type'      => 2
        ]);
        foreach ($attrs as $v) {
            $v['gsa_goods_id'] = $goods_id;
            $v['gsa_spec_id'] = $spec_id;
            $tab->insert($v);
        }
    }
}
