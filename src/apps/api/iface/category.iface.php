<?php
namespace re\rgx;

/**
 * 分类
 */
class category_iface extends base_iface {

    /**
     * 添加分类接口
     * @uri [string] [请求的接口category/add]
     * @data [array] 
     * [ 
     *     "cat_id"      => "1,分类ID,有则修改"
     *     "cat_name"    => "灯具：分类名", 
     *     "cat_parent"  => "0：上级ID，顶级分类则传0",
     *     "cat_sort"    => "99：分类排序",
     *     "cat_user_id" => "0：所属用户ID，0为平台所属",
     *     "cat_type"    => "CAT_MET：分类类别，系统内定常量，参考下表",
     * ]
     * category::helper::$cat_type
     */
    public function add_action () {
        $this->verify([
            'cat_name' => [
                'code' => 100,
                'msg' => '请输入分类名称',
                'rule' => function ($v) {
                    return !empty($v);
                }
            ]
        ]);

        $cat = $this->data;

        $cat_type = category_helper::cat_type($cat['cat_type']);
        if ( empty($cat_type) ) {
            $this->failure('分类类别非法', 101);
        }
        $cat['cat_type']  =  $cat_type['id'];

        $tab = OBJ('category_table');
        if ($cat['cat_parent'] > 0) {
            $parent = $tab->get([
                'cat_id'    => $cat['cat_parent']
            ]);
            if (empty($parent)) {
                $this->failure('无效的父级分类', 102);
            }

            if ( intval($this->data['cat_id'] == $cat['cat_parent']) ) {
                $this->failure('父级分类不能是自己', 103);
            }
            $cat['cat_type']  = $parent['cat_type'];
            $cat['cat_paths'] = $parent['cat_paths'] . "{$parent['cat_id']}#";
            $cat['cat_level'] = $parent['cat_level'] + 1;
        }
        else {
            $cat['cat_paths'] = '#0#';
            $cat['cat_level'] = 0;
        }

        $cat['cat_parent']    = intval($cat['cat_parent']);
        $cat['cat_sort']      = intval($cat['cat_sort']);
        $cat['cat_user_id']   = intval($cat['cat_user_id']);
        if ($tab->load($cat)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $this->success('操作成功', '', '201');
                admin_helper::add_log($user['admin_id'], 'category/add', 1, '添加分类【' . $cat['cat_name'] . '】');
            }
            
        }
        $this->failure('分类添加失败', 104);
    }

    /**
     * [获取分类接口]
     * @return [type] [description]
     * @uri [string] [请求的接口category/list]
     * @data [array] 
     * [ 
     *     "cat_type"    => "CAT_MET：分类类别",
     * ]
     */
    public function list_action () {
        $cat_type = category_helper::cat_type($this->data['cat_type']);
        if ( empty($cat_type) ) {
            $this->failure('分类类别非法', 101);
        }

        $list = OBJ('category_table')->get_all([
            'cat_type'  =>  $cat_type['id']
        ]);

        $list = category_helper::to_tree($list);
        admin_helper::add_log($user['admin_id'], 'category/list', 1, '获取分类列表');
        $this->success('获取分类成功', $list, '201');
    }

    /**
     * [删除分类接口]
     * @uri    [string] [请求的接口category/del]
     * @return [type] [description]
     */
    public function del_action () {
        $id = intval($this->data['cat_id']);

        if ( !$id ) {
            $this->failure('分类ID必须为大于0的数字', 101);
        }

        if (OBJ('category_table')->where([
                'cat_id'    => $id
            ])->count() == 0) {
            $this->failure('分类不存在', 102);
        }

        if (OBJ('category_table')->where([
                'cat_parent'    => $id
            ])->count() > 0) {
            $this->failure('请先删除子类别', 103);
        }

        // 删除
        if (OBJ('category_table')->delete(['cat_id' => $id])['code'] === 0) {
            $this->success('删除成功', '', '201');
            admin_helper::add_log($user['admin_id'], 'category/del', 1, '删除分类，ID：' . $id);
        }
        $this->failure('请先删除子类别', 102);
    }

}//Class End