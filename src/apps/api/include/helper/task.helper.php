<?php
namespace re\rgx;

/**
 * 任务助手类
 */
class task_helper extends rgx {

    /**
     * 任务类型
     * @var array
     */
    public static $type = [
        1       => '短信发送',
        2       => '附件同步',
        3       => '附件删除'
    ];

    /**
     * 短信发送
     */
    const TYPE_SMS          = 1;

    /**
     * 附件同步
     */
    const TYPE_SYNC         = 2;

    /**
     * 附件删除
     */
    const TYPE_DEL          = 3;

    /**
     * 任务处理状态
     * @var [type]
     */
    public static $status = [
        1       => '已失败',
        2       => '新任务',
        3       => '已发布',
        4       => '处理中',
        10      => '已处理',
    ];

    /**
     * 已经失败
     */
    const STATUS_FAIL         = 1;

    /**
     * 新任务 (尚未发布)
     */
    const STATUS_NEW          = 2;

    /**
     * 已发布
     */
    const STATUS_PUBLISHED    = 3;

    /**
     * 处理中
     */
    const STATUS_PROGRESS     = 4;

    /**
     * 已处理成功
     */
    const STATUS_SUCC         = 10;

}

