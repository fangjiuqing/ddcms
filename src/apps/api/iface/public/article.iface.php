<?php
namespace re\rgx;

/**
 * 资讯接口类
 */
class public_article_iface extends base_iface {
    
    /**
     * pc获取智装课堂资讯列表
     */
    public function index_action () {
        $this->success('', CACHE('public@article-list', function () {
            $tab = OBJ('article_table');
            
            $tab->where(['article_status' => 2]);
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
                $arts[$k]['article_content'] = preg_replace('/src="http:\/\/api.dev.ddzz360.com\/data\/attachment\//',
                    'src="' . IMAGE_URL, $arts[$k]['article_content']);
                $arts[$k]['article_admin_nick'] = isset($admin_list[$v['article_admin_id']]) ?
                    $admin_list[$v['article_admin_id']]['admin_account'] : '';
                $arts[$k]['article_cover_thumb'] = IMAGE_URL . $v['article_cover'] . '!500x309';
            }
            return [
                'list'   => $arts,
                'paging' => $paging->to_array(),
            ];
        }, 600));
    }
    
    /**
     * pc获取单条资讯
     * @param $id int 要获取的资讯id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        if (!$id) {
            $this->failure('获取失败', '500');
        }
        //记录点击量
        stat_helper::count(stat_helper::TYPE_ARTICLE, $id, stat_helper::is_mobile() ?
            stat_helper::VIA_WAP : stat_helper::VIA_PC);
        //更新点击量
        $art_tab = OBJ('article_table');
        $stat_ret = count(OBJ('stat_table')->get_all([
            'stat_type'     => stat_helper::TYPE_ARTICLE,
            'stat_ref_id'   => $id,
        ]));
        $art_tab->update(['article_id' => $id, 'article_stat_view' => $stat_ret]);
        
        $this->success('', CACHE('public@article-get-id-' . $id, function () use ($id, $art_tab) {
            $out['row'] = $art_tab->left_join('article_content_table', 'article_id', 'article_id')->get($id) ?: [];
            if ($out['row']) {
                $out['row']['article_status'] = $out['row']['article_status'] == '2' ? true : false;
                $out['row']['article_content'] = htmlspecialchars_decode($out['row']['article_content'], ENT_QUOTES);
                $out['row']['article_content'] = preg_replace('/src="http:\/\/api.dev.ddzz360.com\/data\/attachment\//',
                    'src="' . IMAGE_URL, $out['row']['article_content']);
                $out['row']['article_cover_thumb'] = IMAGE_URL . $out['row']['article_cover'] . '!500x309';
            }
            $out['category'] = category_helper::get_options(3, 0, 0);
            $out['row']['article_admin_name'] = $art_tab->get($out['row']['article_admin_id'])['admin_account'];
            foreach ((array)$out['category'] as $k => $v) {
                $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
            }
            return $out;
        }, 3));
    }
    
}