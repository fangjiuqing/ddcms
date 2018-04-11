<?php
namespace re\rgx;

/**
 * 案例操作接口类
 */
class case_iface extends base_iface {

    /**
     * 添加案例接口
     * @case_title [str] 案例标题
     * @case_cat_id [int] 案例分类id
     * @case_cover [str] 案例封面图片名称
     * @case_content [str] 案例内容
     * @case_id [int] 案例id(可选参数)
     * @case_adate [int] 案例发布时间(可选参数)
     * @case_stat_view [int] 浏览量(可选参数)
     */
    public function save_action () {
        $this->data['case_title'] = filter::text($this->data['case_title']);
        $this->verify([
            'case_cat_id' => [
                'code' => '101',
                'msg'  => '请选择案例所属分类',
                'rule' => filter::$rules['integer'],
            ],
        ]);
        $this->data['case_cover'] = filter::normal($this->data['case_cover']);
        $this->data['case_content'] = filter::html($this->data['case_content']);
        $this->data['case_admin_id'] = (int)$this->login['admin_id'];
        $this->data['case_adate'] = (int)$this->data['case_adate'] ?: REQUEST_TIME;
        $this->data['case_udate'] = REQUEST_TIME;
        $tab = OBJ('case_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $row_id = $this->data['case_id'] ?: $ret['row_id'];
                $ret = OBJ('case_content_table')->replace([
                    'case_id'      => $row_id,
                    'case_content' => $this->data['case_content'],
                ]);
                admin_helper::add_log($this->login['admin_id'], 'case/save', '2', ($this->data['case_id'] ? '案例修改'
                        : '案例新增') . '[' . $row_id . '@' . $this->data['case_title'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 获取单条案例
     * @id [int] 要获取案例的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('case_table')->left_join('case_content_table', 'case_id', 'case_id')
            ->get($id) ?: [];
        if ($out['row']) {
            $out['row']['case_content'] = htmlspecialchars_decode($out['row']['case_content'], ENT_QUOTES);
            $out['row']['case_cover_thumb'] = UPLOAD_URL . image::get_thumb_name($out['row']['case_cover'], '500x309');
        }
        // 分类
        $out['category'] = category_helper::get_options(2, 0, 0);
        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }

        // 风格分类
        $out['style_categories'] = category_helper::get_options(4, 0, 0);
        foreach ((array)$out['style_categories'] as $k => $v) {
            $out['style_categories'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }

        // 空间分类
        $out['space_categories'] = category_helper::get_options(5, 0, 0);
        foreach ((array)$out['space_categories'] as $k => $v) {
            $out['space_categories'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }

        // 户型分类
        $out['type_categories'] = category_helper::get_options(6, 0, 0);
        foreach ((array)$out['type_categories'] as $k => $v) {
            $out['type_categories'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }

        // 布局分类
        $out['layout_categories'] = category_helper::get_options(7, 0, 0);
        foreach ((array)$out['layout_categories'] as $k => $v) {
            $out['layout_categories'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }

        $this->success('', $out);
    }

    /**
     * 获取案例列表接口
     */
    public function list_action () {
        $tab = OBJ('case_table');

        // 分页
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

        $cat_ids = [];
        // 获取记录
        $arts = $tab->map(function ($row) use (&$cat_ids) {
            $cat_ids[$row['case_cat_id']] = 1;
            return $row;
        })->order('case_adate desc')->get_all();

        // 获取对应分类记录
        $cat_list = OBJ('category_table')->akey('cat_id')->get_all([
            'cat_id' => array_keys($cat_ids ?: [0]),
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['cat_name'] = isset($cat_list[$v['case_cat_id']]) ?
                $cat_list[$v['case_cat_id']]['cat_name'] : '';
        }

        $this->success('案例列表获取成功', [
            'list'      => array_values($arts),
            'paging'    => $paging->to_array()
        ]);
    }

    /**
     * 案例删除接口
     * @id [int] 要删除案例的id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('case_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('该案例不存在');
        }
        if (OBJ('case_content_table')->delete(['case_id' => $id])['code'] === 0) {
            if ($tab->delete(['case_id' => $id])['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'case/del', '3',
                    '删除案例[' . $id . '@' . $ret['case_title'] . ']');
                $this->success('案例删除成功');
            }
        }
        $this->failure('案例删除失败', '101');
    }

}