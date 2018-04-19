<?php
namespace re\rgx;

/**
 * 资讯操作接口类
 */

class article_iface extends ubase_iface {
    
    /**
     * 添加资讯接口
     * @article_title [str] 资讯标题
     * @article_cat_id [int] 资讯分类id
     * @article_cover [str] 资讯封面图片名称
     * @article_content [str] 资讯内容
     * @article_id [int] 资讯id(可选参数)
     * @article_adate [int] 资讯发布时间(可选参数)
     * @article_stat_view [int] 浏览量(可选参数)
     */
    public function save_action () {
        $this->data['article_title'] = filter::text($this->data['article_title']);
        $this->data['article_status'] = $this->data['article_status'] == 'true' ? 2 : 1;
        $this->verify([
            'article_cat_id' => [
                'code' => '101',
                'msg'  => '请选择资讯所属分类',
                'rule' => filter::$rules['integer'],
            ],
        ]);
        $this->data['article_cover'] = filter::normal($this->data['article_cover']);
        $this->data['article_content'] = filter::html($this->data['article_content']);
        $this->data['article_admin_id'] = (int)$this->login['admin_id'];
        $this->data['article_adate'] = (int)$this->data['article_adate'] ?: REQUEST_TIME;
        $this->data['article_udate'] = REQUEST_TIME;
        $this->data['article_stat_view'] = (int)$this->data['article_stat_view'] ?: 0;
        $tab = OBJ('article_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $row_id = $this->data['article_id'] ?: $ret['row_id'];
                $ret = OBJ('article_content_table')->replace([
                    'article_id'      => $row_id,
                    'article_content' => $this->data['article_content'],
                ]);
                admin_helper::add_log($this->login['admin_id'], 'article/save', '2', ($this->data['article_id'] ? '资讯修改'
                        : '资讯新增') . '[' . $row_id . '@' . $this->data['article_title'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }
    
    /**
     * 获取单条资讯
     * @id [int] 要获取资讯的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('article_table')->left_join('article_content_table', 'article_id', 'article_id')
            ->get($id) ?: [];
        if ($out['row']) {
            $out['row']['article_status']  = $out['row']['article_status'] == '2' ? true : false;
            $out['row']['article_content'] = htmlspecialchars_decode($out['row']['article_content'], ENT_QUOTES);
            $out['row']['article_cover_thumb'] = IMAGE_URL . $out['row']['article_cover'] . '!500x309';
        }
        $out['category'] = category_helper::get_options(3, 0, 0);
        $out['row']['article_admin_name'] = OBJ('admin_table')->get($out['row']['article_admin_id'])['admin_account'];
        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }
        $this->success('', $out);
    }
    
    /**
     * 获取资讯列表接口
     */
    public function list_action () {
        $tab = OBJ('article_table');
        
        // 分页
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        
        $cat_ids = [];
        $article_id = [];
        $admin_id = [];
        // 获取记录
        $arts = $tab->map(function ($row) use (&$cat_ids, &$article_id, &$admin_id) {
            $cat_ids[$row['article_cat_id']] = 1;
            $article_id[$row['article_id']] = 1;
            $admin_id[$row['article_admin_id']] = 1;
            return $row;
        })->order('article_adate desc')->get_all();
        
        // 获取对应分类记录
        $cat_list = OBJ('category_table')->akey('cat_id')->get_all([
            'cat_id' => array_keys($cat_ids ?: [0]),
        ]);
        
        //获取对应文章内容
        $article_list = OBJ('article_content_table')->akey('article_id')->get_all([
            'article_id' => array_keys($article_id ?: [0]),
        ]);
        
        //获取作者列表
        $admin_list = OBJ('admin_table')->akey('admin_id')->get_all([
            'admin_id' => array_keys($admin_id ?: [0]),
        ]);
        
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['cat_name'] = isset($cat_list[$v['article_cat_id']]) ?
                $cat_list[$v['article_cat_id']]['cat_name'] : '';
            $arts[$k]['article_content'] = isset($article_list[$v['article_id']]) ?
                htmlspecialchars_decode($article_list[$v['article_id']]['article_content']) : '';
            $arts[$k]['article_admin_nick'] = isset($admin_list[$v['article_admin_id']]) ?
                $admin_list[$v['article_admin_id']]['admin_account'] : '';
            $arts[$k]['article_cover_thumb'] = IMAGE_URL . $v['article_cover'] . '!500x309';
        }
        
        $this->success('资讯列表获取成功', [
            'list'   => array_values($arts),
            'paging' => $paging->to_array(),
        ]);
    }
    
    /**
     * 资讯删除接口
     * @id [int] 要删除资讯的id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('article_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('该资讯不存在');
        }
        if (OBJ('article_content_table')->delete(['article_id' => $id])['code'] === 0) {
            if ($tab->delete(['article_id' => $id])['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'article/del', '3',
                    '删除资讯[' . $id . '@' . $ret['article_title'] . ']');
                $this->success('资讯删除成功');
            }
        }
        $this->failure('资讯删除失败', '101');
    }
    
}