<?php
namespace re\rgx;

/**
 * Class unit
 * @package re\rgx
 * anthor Fox
 */
class unit_iface extends ubase_iface {
    
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('unit_copy_table');
        if (!$ret = $tab->get($id)) {
            $this->failure('户型不存在');
        }
        if ($tab->delete(['pu_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'unit/del', '3', '删除户型[' . $id . '@]');
            $this->success('操作成功');
        }
        $this->failure('删除户型失败', 101);
    }
    
}
