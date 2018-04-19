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
                    $row['toggle'] = false;
                    return $row;
                })->order('case_id desc')->limit(5)->get_all([
                    'case_cat_id'   => $v['sub_ids'] ?: [0]
                ]);
                unset($cats[$k]['sub_ids']);
            }
            return array_values($cats);
        }, 600));
    }

    /**
     * 案例详情
     * @return [type] [description]
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('case_table')->left_join('case_content_table', 'case_id', 'case_id')->get($id) ?: [];
        $out['attrs'] = $out['images'] = $out['desc'] = null;
        $region_ids = [];
        if ($out['row']) {
            $desc = filter::json_unecsape($out['row']['case_content']);
            $space = category_helper::get_rows(category_helper::TYPE_SPACE, 1);
            $out['attrs'] = $desc['attrs'] ?: null;
            $out['images'] = [];
            array_map(function ($img) use (&$out, $space) {
                $img['image_sm'] = IMAGE_URL . $img['image'] . '!500x309';
                $img['image_lg'] = IMAGE_URL . $img['image'];
                if (!isset($out['images'][$img['cat_id']])) {
                    $out['images'][$img['cat_id']] = [
                        'name'      => $space[$img['cat_id']]['cat_name'],
                        'images'    => []
                    ];
                }
                $out['images'][$img['cat_id']]['images'][] = $img;
            }, $desc['images']);
            $out['images'] = $out['images'] ? array_values($out['images']) : [];

            $out['desc'] = filter::unecsape(htmlspecialchars_decode($desc['desc'], ENT_QUOTES));
            $out['row']['cover'] = IMAGE_URL . $out['row']['case_cover'] . '!500x309';
            if ($out['row']['case_region0']) {
                $region_ids[] = $out['row']['case_region0'];
            }
            if ($out['row']['case_region1']) {
                $region_ids[] = $out['row']['case_region1'];
            }
            $regions = OBJ('region_table')->akey('region_code')->fields('region_code, region_name')->get_all([
                'region_code'   => $region_ids ?: [0]
            ]);
            $out['row']['province'] = $regions[$out['row']['case_region0']]['region_name'];
            $out['row']['city'] = $regions[$out['row']['case_region1']]['region_name'];
            $out['row']['style'] = category_helper::get_rows(category_helper::TYPE_STYLE, 1)[$out['row']['case_style_id']]['cat_name'];
            $out['row']['type'] = category_helper::get_rows(category_helper::TYPE_TYPE, 1)[$out['row']['case_type_id']]['cat_name'];
            unset($out['row']['case_content']);
            $out['designer'] = OBJ('designer_table')->fields([
                'des_id', 'des_name', 'des_title', 'des_cover'
            ])->map(function ($row) {
                $row['des_cover_sm'] = IMAGE_URL . $row['des_cover'] . '!500x309';
                $row['des_cover_lg'] = IMAGE_URL . $row['des_cover'];
                return $row;
            })->get([
                'des_id'    => $out['row']['case_designer_id']
            ]) ?: null;
        }
        $this->success('', $out);
    }
}