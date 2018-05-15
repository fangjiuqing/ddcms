<?php
namespace com\default_api;
use re\rgx as R;

class mq_module extends R\module {

    /**
     * 发布测试
     * @return [type] [description]
     */
    public function publish_action () {

        // 测试新增同步任务
        $data = [
            'key'   => "a.txt",
            'path'  => UPLOAD_PATH . 'pic/a.txt'
        ];
        $tab = R\OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => R\task_helper::TYPE_SYNC,
            'task_status'   => R\task_helper::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => R\filter::json_ecsape($data),
            'task_result'   => ''
        ]);

        $mq = R\mq::get_instance();
        $ret = $mq->publish('sync_add', [
            'id'    => (int)$ret['row_id'],
            'data'  => $data
        ]);

        // 测试新增删除任务
        $tab = R\OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => R\task_helper::TYPE_DEL,
            'task_status'   => R\task_helper::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => R\filter::json_ecsape($data),
            'task_result'   => ''
        ]);

        $mq = R\mq::get_instance();
        $ret = $mq->publish('sync_del', [
            'id'    => (int)$ret['row_id'],
            'data'  => $data
        ]);
        var_dump($ret);
    }

    /**
     * 订阅测试
     * @return [type] [description]
     */
    public function subscribe_action () {
        $mq = R\mq::get_instance();
        $mq->subscribe('task', function ($instance, $channel, $message) {
            var_dump($instance, $channel, $message);
            flush();
            ob_end_flush();
        });
    }

    public function sms_action () {
        // 测试新增短信发送任务
        $data = [
            'tpl_id'    => '117861',
            'mobile'    => '15951077382',
            'code'      => mt_rand(100000, 999999),
            'ttl'       => 5
        ];
        $tab = R\OBJ('task_table');
        $ret = $tab->insert([
            'task_type'     => R\task_helper::TYPE_SMS,
            'task_status'   => R\task_helper::STATUS_NEW,
            'task_adate'    => REQUEST_TIME,
            'task_cdate'    => 0,
            'task_desc'     => R\filter::json_ecsape($data),
            'task_result'   => ''
        ]);

        $mq = R\mq::get_instance();
        $ret = $mq->publish('sms', [
            'id'    => (int)$ret['row_id'],
            'data'  => $data
        ]);
    }

    public function notice_action () {
        R\task_helper::send_notice('15951077382', R\core_helper::$order_type[R\core_helper::ORDER_TYPE_MEASURE], 
            REQUEST_TIME, '13800138000', '小张');
    }
}
