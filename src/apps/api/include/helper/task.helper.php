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
        1       => '短信验证',
        2       => '附件同步',
        3       => '附件删除',
        4       => '预约通知'
    ];

    /**
     * 短信验证
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
     * 预约通知
     */
    const TYPE_SMS_NOTICE   = 4;

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

    /**
     * 同步文件
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public static function sync_file ($file) {
        // 测试新增同步任务
        $data = [
            'key'   => $file,
            'path'  => UPLOAD_PATH . $file
        ];
        $tab = OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => self::TYPE_SYNC,
            'task_status'   => self::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => filter::json_ecsape($data),
            'task_result'   => ''
        ]);
        if ($ret['code'] === 0) {
            return mq::get_instance()->publish('sync_add', [
                'id'    => (int)$ret['row_id'],
                'data'  => $data
            ]);
        }
        return false;
    }

    /**
     * 同步文件
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public static function del_file ($file) {
        // 测试新增同步任务
        $data = [
            'key'   => $file,
            'path'  => UPLOAD_PATH . $file
        ];
        $tab = OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => self::TYPE_DEL,
            'task_status'   => self::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => filter::json_ecsape($data),
            'task_result'   => ''
        ]);
        if ($ret['code'] === 0) {
            return mq::get_instance()->publish('sync_del', [
                'id'    => (int)$ret['row_id'],
                'data'  => $data
            ]);
        }
        return false;
    }

    /**
     * 发送短信验证码
     * @param  [type] $mobile [description]
     * @param  [type] $code   [description]
     * @return [type]         [description]
     */
    public static function send_verify ($mobile, $code) {
        $data = [
            'tpl_id'    => '117861',
            'mobile'    => $mobile,
            'code'      => $code,
            'ttl'       => 5
        ];
        $tab = OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => self::TYPE_SMS,
            'task_status'   => self::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => filter::json_ecsape($data),
            'task_result'   => ''
        ]);

        $mq = mq::get_instance();
        if ($ret['code'] === 0) {
            return mq::get_instance()->publish('sms', [
                'id'    => (int)$ret['row_id'],
                'data'  => $data
            ]);
        }
        return false;
    }

    /**
     * 发送通知短信
     * @param  [type] $mobile       [description]
     * @param  [type] $service_type [description]
     * @param  [type] $date         [description]
     * @param  [type] $mobile       [description]
     * @param  [type] $nick         [description]
     * @return [type]               [description]
     */
    public static function send_notice ($mobile, $service_type, $date, $s_mobile, $s_nick) {
        $data = [
            'tpl_id'    => '120945',
            'mobile'    => $mobile,
            'type'      => core_helper::$order_type[$service_type] ?: $service_type,
            'date'      => date('Y-m-d H:i', $date),
            's_mobile'  => $s_mobile,
            's_nick'    => $s_nick
        ];
        $tab = OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => self::TYPE_SMS_NOTICE,
            'task_status'   => self::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => filter::json_ecsape($data),
            'task_result'   => ''
        ]);

        $mq = mq::get_instance();
        if ($ret['code'] === 0) {
            return mq::get_instance()->publish('sms_notice', [
                'id'    => (int)$ret['row_id'],
                'data'  => $data
            ]);
        }
        return false;
    }
}
