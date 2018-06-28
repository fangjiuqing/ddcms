<?php
namespace re\rgx;

/**
 * 设计师接口类
 */
class public_designer_iface extends base_iface {

    public function index_action () {
        // 缓存 10分钟
        $this->success('', CACHE('public@designer-index2', function () {
            $tab = OBJ('designer_table');

            // 分页
            $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

            $out['list'] = $tab->map(function ($row) {
                # 案例图片
                $designer_cases = OBJ('case_table')->fields('case_id, case_cover')->get_all(['case_designer_id' =>
                                                                                               $row['des_id']]);
                if ( !empty($designer_cases) ) {
                    $nums = 0;
                    foreach ( $designer_cases as $v ) {
                        if ($nums == 4) break;
                        $row['case_images'][$nums]['lg'] = IMAGE_URL . $v['case_cover'];
                        $row['case_images'][$nums]['sm'] = IMAGE_URL . $v['case_cover'] . '!500x309';
                        $row['case_images'][$nums]['case_id']   = $v['case_id'];
                        $nums++;
                    }
                }

                $region_ids[$row['des_region0']] = 0;
                $region_ids[$row['des_region1']] = 0;
                $regions = OBJ('region_table')->akey('region_code')->fields('region_code, region_name')->get_all([
                    'region_code'   => array_keys($region_ids ?: [0])
                ]);

                $row['province'] = $regions[$row['des_region0']]['region_name'];
                $row['city'] = $regions[$row['des_region1']]['region_name'];

                $row['des_cover'] = IMAGE_URL . $row['des_cover'] . '!364x490';
                $row['stags']  = explode('#', $row['des_style_tags']);
                $row['awards'] = explode('#', $row['des_awards']);
                $row['toggle'] = false;
                return $row;
            })->get_all();
            $out['paging'] = $paging->to_array();
            return $out;
        }, 600));
    }

    public function get_action () {
        $id = intval($this->data['id']);
        if ( !$id ) {
            $this->failure('获取失败' , '500');
        }
        stat_helper::count(stat_helper::TYPE_DESIGNER, $id, stat_helper::is_mobile() ? stat_helper::VIA_WAP : stat_helper::VIA_PC);
        // 缓存 10分钟
        $this->success('', CACHE('public@designer-get1-id-' . $id, function () use ($id) {
            $tab        = OBJ('designer_table');
            $out['row'] = $tab->get($id) ?: [];
            $out['stags'] = null;
            $region_ids = [];
            if ($out['row']) {
                $out['row']['des_about']    = htmlspecialchars_decode($out['row']['des_about'], ENT_QUOTES);
                //$out['row']['des_cover_lg'] = IMAGE_URL . $out['row']['des_cover'];
                $out['row']['des_cover_sm'] = IMAGE_URL . $out['row']['des_cover'] . '!364x490';
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

                $case_id = OBJ('case_table')->fields('case_id')->get_all(['case_designer_id' => $id]);
                $case_ids= [];

                foreach ( $case_id as $v) {
                    $case_ids[] = $v['case_id'];
                }
                $out['row']['case_content'] = [];
                if ( !empty($case_ids) ) {
                    $designer_cases_content = OBJ('case_content_table')->fields('case_id,case_content')->where('case_id in (' . join(',' , $case_ids) . ')' )->get_all();

                    foreach ( $designer_cases_content as $k => $v ) {
                        $desc = filter::json_unecsape($v['case_content']);
                        $out['row']['case_content'][] = htmlspecialchars_decode($desc['desc'],ENT_QUOTES);
                    }
                }

                # 风格标签
                if ( $out['row']['des_style_tags'] ) {
                    $out['stags'] = explode('#' , $out['row']['des_style_tags']);
                }
                # 获奖情况
                if ( $out['row']['des_awards'] ) {
                    $out['awards'] = explode('#' , $out['row']['des_awards']);
                }

                # 案例图片
                $designer_cases = OBJ('case_table')->fields('case_cover')->get_all(['case_designer_id' => $id]);
                if ( !empty($designer_cases) ) {
                    $nums = 0;
                    foreach ( $designer_cases as $v ) {
                        if ($nums == 4) break;
                        $out['case_images'][$nums]['lg'] = IMAGE_URL . $v['case_cover'];
                        $out['case_images'][$nums]['sm'] = IMAGE_URL . $v['case_cover'] . '!500x309';
                        $nums++;
                    }
                }

            }
            return $out;
        }, 3));
    }
}