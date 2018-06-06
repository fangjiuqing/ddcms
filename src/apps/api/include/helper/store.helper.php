<?php
namespace re\rgx;

/**
 * 商城助手类
 * @author reginx
 */
class store_helper extends rgx {

    /**
     * 属性输入方式
     * @var [type]
     */
    public static $attr_input_type = [
        1   => '输入',
        2   => '选择'
    ];

    /**
     * 输入方式
     */
    const ATTR_INPUT_NORMAL         = 1;

    /**
     * 选择方式
     */
    const ATTR_INPUT_SELECT         = 2;

    /**
     *  属性是否可以被筛选
     * @var [type]
     */
    public static $attr_type = [
        1   => '普通属性',
        2   => '规格筛选'
    ];

    /**
     * 不可被筛选
     */
    const ATTR_TYPE_NORMAL          = 1;

    /**
     * 可被筛选
     */
    const ATTR_TYPE_FILTER          = 2;

    /**
     * 获取商品类型
     * @param  boolean $use_cache [description]
     * @param  boolean $has_attrs [description]
     * @return [type]             [description]
     */
    public static function get_goods_types ($use_cache = false, $has_attrs = false) {
        $func = function () use ($has_attrs) {
            $ret = OBJ('goods_type_table')->akey()->get_all();
            if ($has_attrs) {
                OBJ('goods_attr_table')->map(function ($row) use (&$ret) {
                    $ret[$row['ga_type_id']]['attrs'][$row['ga_id']] = [
                        'id'        => $row['ga_id'],
                        'name'      => $row['ga_name'],
                        'input_type'    => ['', 'input', 'select'][$row['ga_input_type']],
                        'type'      => $row['ga_type'],
                        'value'     => '',
                        'values'    => $row['ga_values'] ? explode("\n", $row['ga_values']) : []
                    ];
                    return null;
                })->get_all([
                    'ga_type_id'    => array_keys($ret ?: [0])
                ]);
            }
            return $ret;
        };
        return $use_cache ? CACHE("store@types-" . ($has_attrs ? '-all-attrs' : '-all'), $func, 86400) : $func();
    }

}

