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
    public static $attr_filter = [
        1   => '否',
        2   => '是'
    ];

    /**
     * 不可被筛选
     */
    const ATTR_FILTER_NO            = 1;

    /**
     * 可被筛选
     */
    const ATTR_FILTER_YES           = 2;
}
