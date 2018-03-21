<?php
namespace re\rgx;

/**
 * 资讯操作接口类
 */
class article_iface extends base_iface
{

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
    public function save_action()
    {
        $this->data['article_title'] = filter::text($this->data['article_title']);
        $this->verify([
            'article_cat_id' => [
                'code' => '101',
                'msg' => '请输入正确的分类id',
                'rule' => filter::$rules['integer']
            ],
        ]);
        $this->data['article_cover'] = filter::normal($this->data['article_cover']);
        $this->data['article_content'] = filter::text($this->data['article_content']);
        $this->data['article_admin_id'] = (int)$this->login['admin_id'];
        $this->data['article_adate'] = (int)$this->data['article_adate'] ?: REQUEST_TIME;
        $this->data['article_udate'] = REQUEST_TIME;
        $this->data['article_stat_view'] = (int)$this->data['article_stat_view'] ?: 0;
        $article_tab = OBJ('article_table');
        $flag = !$article_tab->get((int)$this->data['article_id']);
        if ($flag) {
            unset($this->data['article_id']);
        }
        else {
            $this->data['article_id'] = intval($this->data['article_id']);
        }
        if ($article_tab->load($this->data)) {
            $ret = $flag ? $article_tab->save() : $article_tab->update($this->data);
            if ($ret['code'] != 0) {
                $this->failure('操作失败', '102');
            }
        }
        $this->data['article_id'] = $flag ? $ret['row_id'] : $this->data['article_id'];
        $content_tab = OBJ('article_content_table');
        if ($content_tab->load($this->data)) {
            $result = $flag ? $content_tab->save() : $content_tab->update($this->data);
            if ($result['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'article/save', '2', ($flag ? '资讯新增' : '资讯修改') . 'ID:' . $this->data['article_id']);
                $this->success('操作成功');
            }
        }
        $this->failure($article_tab->get_first_error());
    }

    /**
     * 获取单条资讯
     * @id [int] 要获取资讯的id
     */
    public function get_action()
    {
        $id = intval($this->data['id']);
        $out = OBJ('article_table')->map(function ($arg) use ($id) {
            $arg['article_content'] = OBJ('article_content_table')->get([
                'article_id' => $id,
            ])['article_content'] ?: '';
            $arg['cat_name'] = OBJ('category_table')->get($arg['article_cat_id'])['cat_name'] ?: '';
            return $arg;
        })->get($id);
        if (empty($out)) {
            $this->failure('查询的资讯不存在');
        }
        $this->success('资讯获取成功', $out);
    }

    /**
     * 获取资讯列表接口
     */
    public function list_action()
    {
        $cat_ids = [];
        $arts = OBJ('article_table')->map(function ($row) use (&$cat_ids) {
            $cat_ids[$row['article_cat_id']] = 1;
            return $row;
        })->get_all();
        $cat_list = OBJ('category_table')->akey('cat_id')->get_all([
            'cat_id' => array_keys($cat_ids ?: [0])
        ]);
        foreach ((array)$arts as $k => $v) {
            $arts[$k]['cat_name'] = isset($cat_list[$v['article_cat_id']]) ? $cat_list[$v['article_cat_id']]['cat_name'] : '';
        }
        $this->success('资讯列表获取成功', $arts);
    }

    /**
     * 资讯删除接口
     * @id [int] 要删除资讯的id
     */
    public function del_action()
    {
        $id = intval($this->data['id']);
        $ret = OBJ('article_table')->get($id);
        if (empty($ret)) {
            $this->failure('该资讯不存在');
        }
        if (OBJ('article_content_table')->delete(['article_id' => $id,])['code'] === 0) {
            if (OBJ('article_table')->delete(['article_id' => $id,])['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'article/del', '3', '删除资讯ID:' . $id);
                $this->success('资讯删除成功');
            }
        }
        $this->failure('资讯删除失败', '101');
    }

}