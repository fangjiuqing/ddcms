<?php
namespace re\rgx;

/**
 * 案例管理接口
 */
class case_iface extends base_iface {

    /**
     * 获取案例记录
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $out['row'] = OBJ('case_table')->
            left_join('case_content_table', 'case_id', 'case_id')->get($id) ?: [];
        $out['attrs'] = $out['images'] = $out['desc'] = null;
        $region_ids = [];
        if ($out['row']) {
            $desc = filter::json_unecsape($out['row']['case_content']);
            $out['attrs'] = $desc['attrs'] ?: null;
            $out['images'] = $desc['images'] ?: null;
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
        // 设计师
        $out['designer'] = OBJ('designer_table')->fields('des_id, des_name, des_title')->get_all();
        foreach ((array)$out['category'] as $k => $v) {
            $out['category'][$k]['space'] = str_repeat('&nbsp;&nbsp;&nbsp;', $v['cat_level']) . $v['cat_name'];
        }
        $this->success('', $out);
    }

    /**
     * 案例保存
     * @return [type] [description]
     */
    public function save_action () {
        $this->check_login();

        // 输入数据
        $case = $this->data['base'];
        $images = $this->data['images'];
        $attrs = $this->data['attrs'];
        $desc = $this->data['desc'];

        // 默认值
        $case['case_id'] = $case['case_id'] ?: 0;
        $case['case_admin_id'] = $this->login['admin_id'];
        $case['case_admin_nick'] = $this->login['admin_nick'];
        $case['case_adate'] = $case['case_adate'] ?: REQUEST_TIME;
        $case['case_udate'] = REQUEST_TIME;
        $case['case_images'] = [];
        $case['case_image_count'] = count($images);
        $case['case_style_tags'] = $case['case_style_tags'] ?: '';
        $case['case_type_id'] = $case['case_type_id'] ?: 0;
        $case['case_layout_tags'] = $case['case_layout_tags'] ?: '';
        $case['case_designer_id'] = $case['case_designer_id'] ?: 0;
        $case['case_region0'] = $case['case_region0'] ?: 0;
        $case['case_region1'] = $case['case_region1'] ?: 0;
        $case['case_region2'] = $case['case_region2'] ?: 0;
        $case['case_community_id'] = $case['case_community_id'] ?: 0;
        $case['case_views'] = $case['case_views'] ?: 0;

        foreach ((array)$images as $k => $v) {
            if (!isset($case['case_images'][$v['cat_id']])) {
                $case['case_images'][$v['cat_id']] = $v['image'];
            }
        }
        $case['case_images'] = join('#', $case['case_images']);

        // 输入验证
        $this->verify([
            'case_title'    => [
                'code'  => '1',
                'msg'   => '请输入案例名称',
                'rule'  => filter::$rules['require'],
            ],
            'case_cat_id'   => [
                'code'  => '1',
                'msg'   => '请选择所属分类',
                'rule'  => filter::$rules['number'],
            ],
            'case_style_id' => [
                'code'  => '1',
                'msg'   => '请选择风格分类',
                'rule'  => filter::$rules['number'],
            ],
            'case_cover'    => [
                'code'  => '1',
                'msg'   => '请设置案例封面',
                'rule'  => filter::$rules['require'],
            ]
        ], $case);

        // 案例入库
        $ctab = OBJ('case_table');
        if ($ctab->load($case)) {
            $ret = $ctab->save();
            if ($ret['code'] === 0) {
                $case['case_id'] = $case['case_id'] ?: $ret['row_id'];
                OBJ('case_content_table')->replace([
                    'case_id'       => $case['case_id'],
                    'case_content'  => filter::json_ecsape([
                        'images'    => $images,
                        'attrs'     => $attrs,
                        'desc'      => $desc
                    ])
                ]);
                admin_helper::add_log($this->login['admin_id'], 'case/save', '2', 
                    ($this->data['base']['case_id'] ? '案例修改' : '案例新增') . 
                    '[' . $case['case_id'] . '@' . $case['case_title'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($ctab->get_error_desc());
    }

    /**
     * 列表
     */
    public function list_action () {
        $out = [];
        $region_ids = [];
        $tab = OBJ('case_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);

        $out['list'] = $tab->map(function ($row) use (&$region_ids) {
            $region_ids[$row['case_region0']] = 0;
            $region_ids[$row['case_region1']] = 0;
            $region_ids[$row['case_region2']] = 0;
            $row['images'] = explode('#', $row['case_images']);
            return $row;
        })->order('case_udate desc')->get_all();

        unset($region_ids[0], $region_ids['']);

        $out['paging'] = $paging;
        $out['attrs'] = [];
        $out['attrs']['type'] = material_helper::$type;
        $out['attrs']['region'] = OBJ('region_table')->fields('region_code,region_name')->akey('region_code')->get_all([
            'region_code'   => array_keys($region_ids ?: [0])
        ]);
        $out['attrs']['cat'] = category_helper::get_rows(2, true);
        $out['attrs']['style'] = category_helper::get_rows(4, true);
        $out['attrs']['space'] = category_helper::get_rows(5, true);
        $out['attrs']['type'] = category_helper::get_rows(6, true);
        $out['attrs']['layout'] = category_helper::get_rows(7, true);
        $out['attrs']['upload_url'] = UPLOAD_URL;
        $out['attrs']['image_url'] = IMAGE_URL;
        $this->success('', $out);
    }

    /**
     * 案例删除
     * @return [type] [description]
     */
    public function del_action () {
        $this->check_login();
        $id = intval($this->data['id']);
        $tab = OBJ('case_table');
        $case = $tab->left_join('case_content_table', 'case_id', 'case_id')->get($id) ?: [];

        if (!empty($case)) {
            $images = filter::json_unecsape($case['case_content'])['images'];
            $images[] = [
                'image'     => $case['case_cover']
            ];
            foreach ((array)$images as $v) {
                if (upload_helper::is_upload_file($v['image'])) {
                    unlink(UPLOAD_PATH . $v['image']);
                }
            }
            $tab->delete([
                'case_id'   => $id
            ]);
            OBJ('case_content_table')->delete([
                'case_id'   => $id
            ]);
            admin_helper::add_log($this->login['admin_id'], 'case/del', '3',
                    '删除案例[' . $id . '@' . $case['case_title'] . ']');
            $this->success('删除成功');
        }
        $this->failure('案例删除失败', '101');
    }
}
