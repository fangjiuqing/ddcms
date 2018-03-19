<?php
namespace re\rgx;

/**
 * 资讯操作接口类
 */
class news_iface extends base_iface {

    /**
     * 添加资讯接口
     * @article_title [str] 资讯标题
     * @article_cat_id [int] 资讯分类id
     * @article_cover [str] 资讯封面图片名称
     * @article_content [str] 资讯内容
     */
    public function save_action () {
        $this->data['article_title'] = filter::text($this->data['article_title']);
        $this->verify([
            'article_cat_id' => [
                'code' => '101',
                'msg'  => '请输入正确的分类id',
                'rule' => filter::$rules['integer']
            ],
        ]);
        $this->data['article_cover'] = filter::normal($this->data['article_cover']);
        $this->data['article_content'] = filter::text($this->data['article_content']);
        $this->data['article_admin_id'] = $this->login['admin_id'];
        $this->data['article_adate'] = (int)$this->data['article_adate'] ?: REQUEST_TIME;
        $this->data['article_udate'] = REQUEST_TIME;
        $this->data['article_stat_view'] = (int)$this->data['article_stat_view'] ?: 0;
        $article_tab = OBJ('article_table');
        if ($article_tab->load($this->data)) {
            $ret = $article_tab->save();
            if ($ret['code'] != 0) {
                $this->failure('资讯添加失败', '102');
            }
        }
        $this->data['article_id'] = $ret['row_id'];
        $content_tab = OBJ('article_content_table');
        if ($content_tab->load($this->data)) {
            $result = $content_tab->save();
            if ($result['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'news_category/save', '1', '资讯添加成功');
                $this->success('资讯添加成功');
            }
        }
        $this->failure($article_tab->get_first_error());
    }

    /**
     * 获取单条资讯
     * @id [int] 要获取的资讯的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out = OBJ('article_table')->get($id);
        if (empty($out)) {
            $this->failure('查询的资讯不存在');
        }
        $content = OBJ('article_content_table')->get([
            'article_id' => $id,
        ]);
        if (empty($content)) {
            $this->failure('资讯内容为空', '101');
        }
        $out['article_content'] = $content['article_content'];
        $this->success('资讯获取成功', $out);
    }

    /**
     * 获取资讯列表接口
     */
    public function list_action () {
        $article = OBJ('article_table')->get_all();
        if (empty($article)) {
            $this->success('没有资讯信息');
        }
        $content = OBJ('article_content_table')->get_all();
        if (empty($content)) {
            $this->success('资讯内容为空');
        }
        foreach ($article as $article_val) {
            foreach ($content as $content_val) {
                if ($article_val['article_id'] == $content_val['article_id']) {
                    $article_val['article_content'] = $content_val['article_content'];
                    $out[] = $article_val;
                }
            }
        }
        $this->success('资讯列表获取成功', $out);
    }

    /**
     * 资讯删除接口
     * @id [int] 删除资讯的id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        if (empty($id)) {
            $this->failure('请输入正确的资讯id');
        }
        if (OBJ('article_content_table')->delete([
                'article_id' => $id,
            ])['code'] === 0) {
            if (OBJ('article_table')->delete([
                    'article_id' => $id,
                ])['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'news/del', '1', '删除资讯，ID：' . $id);
                $this->success('资讯删除成功');
            }
        }
        $this->failure('资讯删除失败', '101');
    }

}