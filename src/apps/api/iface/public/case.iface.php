<?php
namespace re\rgx;

/**
 * 案例接口类
 */
class public_case_iface extends base_iface {

    /**
     * 案例列表
     * @return [type] [description]
     */
    public function index_action () {
        // 缓存 10分钟
        $this->success('', CACHE('public@case-list', function () {
            // 查询列表页展示的分类
            $cats = OBJ('category_table')->akey('cat_id')->order('cat_level desc')->fields([
                'cat_id', 'cat_paths', 'cat_name', 'cat_status'
            ])->get_all([
                'cat_type'  => category_helper::TYPE_CASE
            ]);
            foreach ((array)$cats as $k => $v) {
                if ($v['cat_paths'] != '#0#') {
                    $root_id = (int)substr($v['cat_paths'], 3);
                    if ($cats[$root_id]['cat_status'] == 2) {
                        $cats[$root_id]['sub_ids'][] = $v['cat_id'];
                    }
                    unset($cats[$k]);
                }
                else {
                    if ($v['cat_status'] == 2) {
                        $cats[$k]['sub_ids'][] = $v['cat_id'];
                        unset($cats[$k]['cat_paths'], $cats[$k]['cat_status']);
                    }
                    else {
                        unset($cats[$k]);
                    }
                }
            }

            $ctab = OBJ('case_table');
            $types = category_helper::get_rows(category_helper::TYPE_TYPE);
            foreach ((array)$cats as $k => $v) {
                $cats[$k]['list'] = $ctab->fields(
                    'case_id,case_title,case_cover,case_area,case_price,case_type_id'
                )->map(function ($row) use ($types) {
                    $row['case_cover_lg'] = IMAGE_URL . $row['case_cover'];
                    $row['case_cover_sm'] = IMAGE_URL . $row['case_cover'] . '!500x309';
                    $row['type'] = $types[$row['case_type_id']]['cat_name'];
                    return $row;
                })->order('case_id desc')->limit(5)->get_all([
                    'case_cat_id'   => $v['sub_ids'] ?: [0]
                ]);
                unset($cats[$k]['sub_ids']);
            }
            return array_values($cats);
        }, 600));
    }

    public function get_action () {}
}