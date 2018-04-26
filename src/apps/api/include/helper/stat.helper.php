<?php
namespace re\rgx;

/**
 * 统计助手类
 */
class stat_helper extends rgx {

    /**
     * 统计数据类型
     * @var [type]
     */
    public static $type = [
        1       => '资讯',
        2       => '案例',
        3       => '设计师'
    ];

    /**
     * 资讯类型
     */
    const TYPE_ARTICLE          = 1;

    /**
     * 案例类型
     */
    const TYPE_CASE             = 2;

    /**
     * 设计师类型
     */
    const TYPE_DESIGNER         = 3;

    /**
     * 访问来源
     * @var [type]
     */
    public static $via = [
        1       => 'PC',
        2       => 'WAP'
    ];

    /**
     * 来源 pc
     */
    const VIA_PC                = 1;

    /**
     * 来源 wap
     */
    const VIA_WAP               = 2;
}
