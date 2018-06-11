<?php
namespace re\rgx;

/**
 * 商品分类接口类
 * @author reginx
 */
class store_goods_category_iface extends category_iface {

    /**
     * 商城商品分类
     * @var integer
     */
    public $type_id = 10;


    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->data['id'] = intval($this->data['id']);
        $out = OBJ('category_table')->fields([
            'cat_id', 'cat_name', 'cat_parent', 'cat_type', 'cat_sort', 'cat_status', 'cat_extra'
        ])->get(
            (int)$this->data['id']
        );
        if ($this->data['parent']) {
            $out['parent_options'] = category_helper::get_options($this->type_id, 0, $this->data['id']);
            array_unshift($out['parent_options'], [
                'cat_id'    => 0, 
                'cat_name'  => '作为一级分类', 
                'cat_level' => 0, 
                'space'     => '作为一级分类'
            ]);
        }
        $out['cat_parent'] = intval($out['cat_parent']);
        $out['status_options'] = category_helper::$status;
        $out['type'] = OBJ('goods_type_table')->akey('gt_id')->get_all();
        OBJ('goods_attr_table')->map(function ($row) use (&$out) {
            $out['type'][$row['ga_type_id']]['attrs'][$row['ga_id']] = [
                'ga_id'     => $row['ga_id'],
                'ga_name'   => $row['ga_name']
            ];
            return null;
        })->get_all([
            'ga_type_id'    => array_keys($out['type'] ?: [0])
        ]);
        $out['attrs'] = OBJ('goods_attr_table')->akey('ga_id')->fields('ga_id, ga_name')->get_all([
            'ga_id'     => $out['cat_extra'] ? (explode(',', $out['cat_extra'])) : [0]
        ]) ?: null;
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
        $this->data['cat_extra'] = join(',', array_keys($this->data['attrs']));
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
}
