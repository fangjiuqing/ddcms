<?php
namespace re\rgx;

/**
 *  核心助手类
 */
class core_helper extends rgx {

    /**
     * 方形
     * @var [type]
     */
    public static $house_type = [
        1   => '平层',
        2   => '复式',
        3   => '别墅'
    ];

    /**
     * 户型
     * @var [type]
     */
    public static $house_mode = [
        1   => '一室一厅',
        20  => '两室一厅',
        21  => '两室两厅',
        30  => '三室一厅',
        31  => '三室两厅',
        40  => '四室一厅',
        41  => '四室两厅',
        42  => '四室三厅',
        50  => '五室一厅',
        51  => '五室两厅',
        60  => '六室三厅',
    ];

    /**
     * 装修风格
     * @var array
     */
    public static $house_style = [
        10  => '现代',
        20  => '中式',
        30  => '欧式',
        40  => '美式'
    ];

    /**
     * 是否现房
     * @var [type]
     */
    public static $house_exists = [
        1   => '否',
        2   => '是'
    ];

    /**
     * 客户来源
     * @var [type]
     */
    public static $customer_via = [
        1   => '网销',
        2   => '电视广告',
        3   => '户外广告',
        4   => '市场',
        5   => '网络',
        6   => '上门客户'
    ];

    public static $order_type = [
        1   => '量房',
        2   => '装修',
        3   => '完工'
    ];
    
    /**
     * 户型面积范围
     * @var array
     */
    public static $area_range = [
        0 => '<60m²',
        1 => '60-80m²',
        2 => '80-100m²',
        3 => '100-120m²',
        4 => '120-150m²',
        5 => '>150m²',
    ];
    
    const RANGE_60 = 0;
    
    const RANGE_80 = 1;
    
    const RANGE_100 = 2;
    
    const RANGE_120 = 3;
    
    const RANGE_150 = 4;
    
    const RANGE_MAX = 5;
    
}