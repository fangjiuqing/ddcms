<?php
namespace re\rgx;

/**
 * 设计师操作接口类
 */

class desinger_iface extends base_iface {

    /**
     * 添加设计师接口
     * @des_title [str] 设计师标题
     * @des_cat_id [int] 设计师分类id
     * @des_cover [str] 设计师封面图片名称
     * @des_content [str] 设计师内容
     * @des_id [int] 设计师id(可选参数)
     * @des_adate [int] 设计师发布时间(可选参数)
     * @des_stat_view [int] 浏览量(可选参数)
     */
    public function save_action () {
        $this->check_login();
        $this->data['des_title'] = filter::text($this->data['des_title']);
        $this->verify([
            'des_cat_id' => [
                'code' => '101',
                'msg'  => '请选择设计师所属分类',
                'rule' => filter::$rules['integer'],
            ],
        ]);
        $this->data['des_cover'] = filter::normal($this->data['des_cover']);
        $this->data['des_content'] = filter::html($this->data['des_content']);
        $this->data['des_admin_id'] = (int)$this->login['admin_id'];
        $this->data['des_adate'] = (int)$this->data['des_adate'] ?: REQUEST_TIME;
        $this->data['des_udate'] = REQUEST_TIME;
        $this->data['des_stat_view'] = (int)$this->data['des_stat_view'] ?: 0;
        $tab = OBJ('des_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $row_id = $this->data['des_id'] ?: $ret['row_id'];
                $ret = OBJ('des_content_table')->replace([
                    'des_id'      => $row_id,
                    'des_content' => $this->data['des_content'],
                ]);
                admin_helper::add_log($this->login['admin_id'], 'des/save', '2', ($this->data['des_id'] ? '设计师修改'
                        : '设计师新增') . '[' . $row_id . '@' . $this->data['des_title'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 获取单条设计师
     * @id [int] 要获取设计师的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('des_table')->left_join('des_content_table', 'des_id', 'des_id')
            ->get($id) ?: [];
        if ($out['row']) {
            $out['row']['des_content'] = htmlspecialchars_decode($out['row']['des_content'], ENT_QUOTES);
            $out['row']['des_cover_thumb'] = IMAGE_URL . $out['row']['des_cover'] . '!500x309';
        }
        $out['category'] = category_helper::get_options(3, 0, 0);
        $out['row']['des_admin_name'] = OBJ('admin_table')->get($out['row']['des_admin_id'])['admin_account'];
        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }
        $this->success('', $out);
    }

    /**
     * 获取设计师列表接口
     */
    public function list_action () {
        $tab = OBJ('des_table');

        // 分页
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

        $cat_ids = [];
        $des_id = [];
        $admin_id = [];
        // 获取记录
        $arts = $tab->map(function ($row) use (&$cat_ids, &$des_id, &$admin_id) {
            $cat_ids[$row['des_cat_id']] = 1;
            $des_id[$row['des_id']] = 1;
            $admin_id[$row['des_admin_id']] = 1;
            return $row;
        })->order('des_adate desc')->get_all();

        // 获取对应分类记录
        $cat_list = OBJ('category_table')->akey('cat_id')->get_all([
            'cat_id' => array_keys($cat_ids ?: [0]),
        ]);

        //获取对应文章内容
        $des_list = OBJ('des_content_table')->akey('des_id')->get_all([
            'des_id' => array_keys($des_id ?: [0]),
        ]);

        //获取作者列表
        $admin_list = OBJ('admin_table')->akey('admin_id')->get_all([
            'admin_id' => array_keys($admin_id ?: [0]),
        ]);

        foreach ((array)$arts as $k => $v) {
            $arts[$k]['cat_name'] = isset($cat_list[$v['des_cat_id']]) ?
                $cat_list[$v['des_cat_id']]['cat_name'] : '';
            $arts[$k]['des_content'] = isset($des_list[$v['des_id']]) ?
                htmlspecialchars_decode($des_list[$v['des_id']]['des_content']) : '';
            $arts[$k]['des_admin_nick'] = isset($admin_list[$v['des_admin_id']]) ?
                $admin_list[$v['des_admin_id']]['admin_account'] : '';
            $arts[$k]['des_cover_thumb'] = IMAGE_URL . $v['des_cover'] . '!500x309';
        }

        $this->success('设计师列表获取成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }

    /**
     * 设计师删除接口
     * @id [int] 要删除设计师的id
     */
    public function del_action () {
        $this->check_login();
        $id = intval($this->data['id']);
        $tab = OBJ('des_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('该设计师不存在');
        }
        if (OBJ('des_content_table')->delete(['des_id' => $id])['code'] === 0) {
            if ($tab->delete(['des_id' => $id])['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'des/del', '3',
                    '删除设计师[' . $id . '@' . $ret['des_title'] . ']');
                $this->success('设计师删除成功');
            }
        }
        $this->failure('设计师删除失败', '101');
    }

}