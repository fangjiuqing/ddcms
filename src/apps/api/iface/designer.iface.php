<?php
namespace re\rgx;

/**
 * 设计师操作接口类
 */

class designer_iface extends base_iface {

    /**
     * 添加设计师接口
     * @des_title [str] 设计师标题
     * @des_cat_id [int] 设计师分类id
     * @des_cover [str] 设计师封面图片名称
     * @des_content [str] 设计师内容
     * @des_id [int] 设计师id(可选参数)
     * @des_adate [int] 设计师发布时间(可选参数)
     * @des_stat_view [int] 浏览量(可选参数)
     */
    public function save_action () {
        $this->check_login();
        $base = $this->data['base'];
        $this->data['des_id']   = (int)$base['des_id'];
        $this->data['des_name'] = filter::text($base['des_name']);
        $this->data['des_title'] = filter::normal($base['des_title']);
        $this->data['des_workyears'] = (int)$base['des_workyears'];
        $this->data['des_price'] = filter::text($base['des_price']);
        $this->data['des_concept_tags'] = filter::text($base['des_concept_tags']);
        $this->data['des_slogan'] = filter::text($base['des_slogan']);
        $this->data['des_region0'] = (int)$base['des_region0'];
        $this->data['des_region1'] = (int)$base['des_region1'];
        $this->data['des_case_id'] = (int)$base['des_case_id'];
        $this->data['des_about'] = filter::html($base['des_about']);
        $this->data['des_cover'] = filter::text($base['des_cover']);

        # 设计师获奖情况
        $attrs = $this->data['attrs'];

        if ( !empty($attrs) ) {
            $this->data['des_awards'] = '';
            if ( count($attrs) > 20 ) {
                $this->failure('获奖奖项最多不超过20项目');
            }
            foreach ( $attrs as $v ) {
                if (preg_match('/#/', $v['val'])) {
                    $this->failure('请勿包含特殊字符[' . $v['val'].']');
                }
                $this->data['des_awards'] .= $v['val'] . '#';
            }
            $this->data['des_awards'] = rtrim($this->data['des_awards'] , '#');
        }

        # 设计师风格标签
        $stags = $this->data['styles'];
        if ( !empty($stags) ) {
            if ( count($stags) > 10 ) {
                $this->failure('风格标签最多不超过10个');
            }
            $this->data['des_style_tags'] = '';
            foreach ( $stags as $v ) {
                if (preg_match('/#/', $v)) {
                    $this->failure('请勿包含特殊字符[' . $v.']');
                }
                $this->data['des_style_tags'] .= $v . '#';
            }
            $this->data['des_style_tags'] = rtrim($this->data['des_style_tags'] , '#');
        }

        $tab = OBJ('designer_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $row_id = $this->data['des_id'] ?: $ret['row_id'];
                admin_helper::add_log($this->login['admin_id'], 'designer/save', '2', ($this->data['des_id'] ? '设计师修改'
                        : '设计师新增') . '[' . $row_id . '@' . $this->data['des_name'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 获取单条设计师
     * @id [int] 要获取设计师的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('designer_table')->get($id) ?: [];
        $out['attrs'] = $out['stags'] = null;
        $region_ids = [];

        # 风格标签
        $styles = category_helper::get_rows(category_helper::TYPE_STYLE, 1);
        foreach ( $styles as $k => $v ) {
            if ( !$v['cat_id'] ) continue;
            $out['stags'][$k]['name'] = $v['cat_name'];
        }
        if ($out['row']) {
            $out['row']['des_about'] = htmlspecialchars_decode($out['row']['des_about'], ENT_QUOTES);
            $out['row']['cover'] = IMAGE_URL . $out['row']['des_cover'] . '!500x309';
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
            // if ( $out['row']['des_style_tags'] ) {
            //     $styles = category_helper::get_rows(category_helper::TYPE_STYLE, 1);
            //     foreach ( $styles as $k => $v ) {
            //         if ( !$v['cat_id'] ) continue;
            //         $out['stags'][$k]['name'] = $v['cat_name'];
            //     }
            // }
            # 获奖情况
            if ( $out['row']['des_awards'] ) {
                foreach (explode('#' , $out['row']['des_awards']) as $k => $v) {
                    $out['attrs'][$k . mt_rand(5,200)]['val'] = $v;
                }
            }
        }

        # 已选风格标签
        $stags  = explode('#' , $out['row']['des_style_tags']);
        foreach ($stags as $k => $v) {
            $out['styles'][] = $v;
        }
        $this->success('', $out);
    }

    /**
     * 获取设计师列表接口
     */
    public function list_action () {
        $tab = OBJ('designer_table');

        // 分页
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

        $out['list'] = $tab->map(function ($row) use (&$region_ids) {
            $region_ids[$row['des_region0']] = 0;
            $region_ids[$row['des_region1']] = 0;
            $row['stags']     = explode('#', $row['des_style_tags']);
            $row['des_cover'] = IMAGE_URL . $row['des_cover'] . '!500x309';
            return $row;
        })->get_all();

        unset($region_ids[0], $region_ids['']);
        $out['paging'] = $paging;
        $out['attrs']['region'] = OBJ('region_table')->fields('region_code,region_name')->akey('region_code')->get_all([
            'region_code'   => array_keys($region_ids ?: [0])
        ]);
        $this->success('', $out);
    }

    /**
     * 设计师删除接口
     * @id [int] 要删除设计师的id
     */
    public function del_action () {
        $this->check_login();
        $id = intval($this->data['id']);
        $tab = OBJ('designer_table');
        $ret = $tab->get($id);
        if (empty($ret)) {
            $this->failure('该设计师不存在');
        }
        if ($tab->delete(['des_id' => $id])['code'] === 0) {
            upload_helper::remove($ret['des_cover']);
            admin_helper::add_log($this->login['admin_id'], 'designer/del', '3',
                '删除设计师[' . $id . '@' . $ret['des_name'] . ']');
            $this->success('设计师删除成功');
        }
        $this->failure('设计师删除失败', '101');
    }

}