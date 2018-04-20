<?php
namespace re\rgx;

/**
 * 分类
 */
class category_iface extends base_iface {


    /**
     * 分类类型ID
     * @var integer
     */
    public $type_id = 0;

    /**
     * 构造方法
     * @param [type] $mod   [description]
     * @param [type] $data  [description]
     * @param [type] $login [description]
     */
    public function __construct ($params = []) {
        parent::__construct($params);
        if (!isset(category_helper::$type[$this->type_id])) {
            $this->failure('无效的类型');
        }
    }

    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('category_table')->fields([
            'cat_id', 'cat_name', 'cat_parent', 'cat_type', 'cat_sort', 'cat_status'
        ])->get(
            (int)$this->data['id']
        );
        if ($this->data['parent']) {
            $out['parent_options'] = category_helper::get_options($this->type_id, 0, $this->data['id']);
            array_unshift($out['parent_options'], ['cat_id' => 0, 'cat_name' => '作为一级分类', 'cat_level' => 0]);
            foreach ((array)$out['parent_options'] as $k => $v) {
                $out['parent_options'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
            }
        }
        $out['cat_parent'] = intval($out['cat_parent']);
        $out['status_options'] = category_helper::$status;
        $this->success('', $out);
    }

    /**
     * 添加分类接口
     */
    public function save_action () {
        $this->check_login();
        $this->data['cat_type'] = $this->type_id;
        $tab = OBJ('category_table');
        $this->data['cat_paths'] = '#0#';
        $this->data['cat_level'] = 0;
        $this->data['cat_parent'] = (int)$this->data['cat_parent'];
        $this->data['cat_sort'] = (int)$this->data['cat_sort'];
        $this->data['cat_user_id'] = (int)$this->data['cat_user_id'];
        $this->data['cat_status'] = (int)$this->data['cat_status'];
        if ($this->data['cat_parent'] > 0) {
            $parent = $tab->get((int)$this->data['cat_parent']);
            if (empty($parent)) {
                $this->failure('无效的父级分类');
            }
            if ($this->data['cat_id'] == $this->data['cat_parent']) {
                $this->failure('父级分类不能是自己');
            }
            $this->data['cat_paths'] = $parent['cat_paths'] . "{$parent['cat_id']}#";
            $this->data['cat_level'] = $parent['cat_level'] + 1;
        }

        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'category/save', 1,
                    ($this->data['cat_id'] ? '编辑' : '新增') . '分类[' . $this->data['cat_name'] . ']'
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
        $out = array_values(category_helper::to_tree(OBJ('category_table')->order('cat_level asc, cat_sort desc')->get_all([
            'cat_type'  =>  $this->type_id
        ]), 1));
        foreach ((array)$out as $k => $v) {
            $out[$k]['class'] = 'category_before category_before_' . $v['cat_level'];
            $out[$k]['status'] = category_helper::$status[$v['cat_status']] ?: '默认';
        }
        $this->success('', $out);
    }

    /**
     *  删除
     */
    public function del_action () {
        $id  = intval($this->data['id']);
        $tab = OBJ('category_table');
        $cat = $tab->get($id);
        if (empty($cat)) {
            $this->failure('该分类不存在');
        }

        if ($tab->where([
                "cat_parent"    => $cat['cat_id']
            ])->count() > 0) {
            $this->failure('请先删除下属分类');
        }
        // 删除
        if ($tab->delete(['cat_id' => $id])['code'] === 0) {
            admin_helper::add_log($this->login['admin_id'], 'category/del', 1, '删除分类，ID：' . $id);
            $this->success('删除成功');
        }
        $this->failure('请先删除子类别');
    }

}
