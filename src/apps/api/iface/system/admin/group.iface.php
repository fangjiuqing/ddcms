<?php
namespace re\rgx;

/**
 * 权限管理接口
 */
class system_admin_group_iface extends ubase_iface {

    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('admin_group_table')->get($this->data['id']);
        $out['details'] = null;
        if (!empty($out)) {
            $out['details'] = filter::json_unecsape($out['pag_details']);
        }
        $out['rules'] = admin_helper::$operate;
        $this->success('', $out);
    }

    /**
     * 添加分类接口
     */
    public function save_action () {
        $tab = OBJ('admin_group_table');
        $details = $this->data['details'];
        if ($this->data['pag_id'] == '1') {
            $this->failure('该组别无法编辑');
        }
        if (empty($this->data['pag_name'])) {
            $this->failure('请输入权限组名');
        }
        if (empty($details)) {
            $this->failure('请选择权限');
        }
        $this->data['pag_details'] = filter::json_ecsape($details);

        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'admin/group/save', 1,
                    ($this->data['pag_id'] ? '编辑' : '新增') . '权限组[' . $this->data['pag_name'] . ']'
                );
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_first_error());
    }

    /**
     * 列表
     */
    public function list_action () {
        $out['list'] = OBJ('admin_group_table')->order('pag_id asc')->map(function ($row) {
            $row['desc'] = admin_helper::get_operate_desc(filter::json_unecsape($row['pag_details']));
            unset($row['pag_details']);
            return $row;
        })->get_all();
        $out['attrs']['paging'] = [];
        $this->success('', $out);
    }

    /**
     *  删除
     */
    public function del_action () {
        $id  = intval($this->data['id']);
        if (OBJ('admin_table')->where("admin_group_id = {$id}")->count() > 0) {
            $this->failure('请先删除该权限组下的管理员');
        }

        $tab = OBJ('admin_group_table');
        $cat = $tab->get($id);
        if (empty($cat)) {
            $this->failure('该组别不存在');
        }
        // 删除
        if ($tab->delete(['pag_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'admin/group/del', 1, '删除权限组，ID：' . $id);
            $this->success('删除成功');
        }
        $this->failure('删除失败了');
    }

}
