<?php
namespace re\rgx;

/**
 * 缓存更新模块
 */
class system_flush_iface extends ubase_iface {

    /**
     * 获取缓存清除选项
     * @return [type] [description]
     */
    public function get_action () {
        $this->success('', [
            'api'   => [
                'label'     => '接口缓存',
                'checked'   => false
            ]
        ]);
    }

    /**
     * 执行清理
     * @return [type] [description]
     */
    public function save_action () {
        $tasks = [];
        $items = $this->data['items'];
        foreach ((array)$items as $k => $v) {
            if ($v['checked']) {
                $tasks[] = $k;
            }
        }

        if (empty($tasks)) {
            $this->failure('请选择要清理的缓存');
        }

        $nums = 0;
        foreach ((array)$tasks as $k => $v) {
            $nums += cache::get_instance([], [
                'name'      => 'default',
                'id'        => $v
            ])->flush();
        }
        $this->success('清理成功, 共计清理目录及文件 ' . $nums . ' 个');
    }
}
