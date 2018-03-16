<?php
namespace re\rgx;

/**
 * 资讯操作接口类
 */
class news_iface extends base_iface {

    /**
     * 添加资讯接口
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
        $this->data['article_adate'] = $this->data['article_udate'] = REQUEST_TIME;
        $this->data['article_stat_view'] = 0;
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
     * 资讯列表获取/筛选接口
     */
    public function get_action () {
        $out = OBJ('article_table')->fields([
            'article_id',
            'article_title',
            'article_cat_id',
            'article_cover',
        ])->get_all();
        $this->success('资讯列表获取成功', $out);
    }

    /**
     * 资讯删除接口
     */
    public function del_action () {
        $this->data['id'] = intval($this->data['id']);
        if (OBJ('article_content_table')->delete([
                'article_id' => $this->data['id'],
            ])['code'] === 0) {
            if (OBJ('article_table')->delete([
                    'article_id' => $this->data['id'],
                ])['code'] === 0) {
                $this->success('资讯删除成功');
            }
        }
        $this->failure('资讯删除失败');
    }

}