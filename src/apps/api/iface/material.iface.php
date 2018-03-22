<?php
namespace re\rgx;

/**
 * 分类
 */
class material_iface extends base_iface {


    /**
     * 获取分类详情
     * @return [type] [description]
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('material_table')->get($id) ?: [];
        $out['category'] = category_helper::get_options(1, 0, 0);

        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }
        $out['type'] = material_helper::$type;
        $out['brands'] = OBJ('brand_table')->get_all();
        if ($out['row']) {
            $out['row']['article_content'] = htmlspecialchars_decode($out['row']['article_content'], ENT_QUOTES);
            $out['row']['article_cover_thumb'] = UPLOAD_URL . image::get_thumb_name($out['row']['article_cover'], '500x309');
        }
        $this->success('', $out);
    }

}
