<?php
namespace re\rgx;

/**
 * 案例管理接口
 */
class case_iface extends ubase_iface {

    /**
     * 获取案例记录
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('case_table')->
            left_join('case_content_table', 'case_id', 'case_id')->get($id) ?: [];
        if ($out['row']) {
            $out['row']['case_content'] = htmlspecialchars_decode($out['row']['case_content'], ENT_QUOTES);
            $out['row']['case_cover_thumb'] = IMAGE_URL . $out['row']['case_cover'] . '!500x309';
        }
        // 基本
        $out['category'] = category_helper::get_options(2, 0, 0);
        // 风格
        $out['style'] = category_helper::get_options(4, 0, 0);
        // 空间
        $out['space'] = category_helper::get_options(5, 0, 0);
        // 户型
        $out['type'] = category_helper::get_options(6, 0, 0);
        // 布局
        $out['layout'] = category_helper::get_options(7, 0, 0);
        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }
        $this->success('', $out);
    }
}