<?php
namespace re\rgx;

/**
 * 设计师接口类
 */
class public_designer_iface extends base_iface {

    public function index_action () {
        // 缓存 10分钟
        $this->success('', CACHE('public@designer-list', function () {
            $tab = OBJ('designer_table');

            // 分页
            $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

            $out['list'] = $tab->map(function ($row) use (&$region_ids) {
                $region_ids[$row['des_region0']] = 0;
                $region_ids[$row['des_region1']] = 0;
                $row['des_cover_lg'] = IMAGE_URL . $row['des_cover'];
                $row['des_cover_sm'] = IMAGE_URL . $row['des_cover'] . '!500x309';
                $row['stags']  = explode('#', $row['des_style_tags']);
                $row['awards'] = explode('#', $row['des_awards']);
                return $row;
            })->get_all();

            unset($region_ids[0], $region_ids['']);
            $out['paging'] = $paging;
            $out['attrs']['region'] = OBJ('region_table')->fields('region_code,region_name')->akey('region_code')->get_all([
                'region_code'   => array_keys($region_ids ?: [0])
            ]);

            return $out;
        }, 600));
    }

    public function get_action () {
        $id = intval($this->data['id']);
        if ( !$id ) {
            $this->failure('获取失败' , '500');
        }
        // 缓存 10分钟
        $this->success('', CACHE('public@designer-get-id-' . $id, function () use ($id) {
            $tab        = OBJ('designer_table')->fields('designer_table.*,case_table.case_images');
            $tab->left_join('case_table' , 'des_case_id' , 'case_id');
            $out['row'] = $tab->get($id) ?: [];
            $out['stags'] = null;
            $region_ids = [];
            if ($out['row']) {
                $out['row']['des_about']    = htmlspecialchars_decode($out['row']['des_about'], ENT_QUOTES);
                $out['row']['des_cover_lg'] = IMAGE_URL . $out['row']['des_cover'];
                $out['row']['des_cover_sm'] = IMAGE_URL . $out['row']['des_cover'] . '!500x309';
                if ($out['row']['des_region0']) {
                    $region_ids[] = $out['row']['des_region0'];
                }
                if ($out['row']['des_region1']) {
                    $region_ids[] = $out['row']['des_region1'];
                }
                $regions = OBJ('region_table')->akey('region_code')->fields('region_code, region_name')->get_all([
                    'region_code'   => $region_ids ?: [0]
                ]);
                $out['row']['province'] = $regions[$out['row']['des_region0']]['region_name'];
                $out['row']['city'] = $regions[$out['row']['des_region1']]['region_name'];
                # 风格标签
                if ( $out['row']['des_style_tags'] ) {
                    $out['stags'] = explode('#' , $out['row']['des_style_tags']);
                }
                # 获奖情况
                if ( $out['row']['des_awards'] ) {
                    $out['awards'] = explode('#' , $out['row']['des_awards']);
                }

                # 案例图片
                if ( $out['row']['case_images'] ) {
                    $case_images = explode('#' , $out['row']['case_images']);
                    foreach ($case_images as $k => $v ) {
                        $out['case_images'][$k]['lg'] = IMAGE_URL . $v;
                        $out['case_images'][$k]['sm'] = IMAGE_URL . $v . '!500x309';
                    }
                }
            }
            return $out;
        }, 3));
    }
}