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
        $out['status'] = material_helper::$status;
        $out['goods'] = OBJ('material_goods_table')->map(function ($row) use (&$out) {
            $ret = [
                'id'        => $row['pmg_id'],
                'price'     => $row['pmg_price'],
                'cost_price'=> $row['pmg_cost_price'],
                'stocks'    => $row['pmg_stocks']
            ];
            $attrs = explode('#', substr($row['pmg_desc'], 1, -1));
            foreach ((array)$attrs as $v) {
                $v = explode('=', $v);
                $k = base64_encode($v[0]);
                if (!isset($out['fields'][$k])) {
                    $out['fields'][$k] = $v[0];
                }
                $ret[$k] = $v[1];
            }
            return $ret;
        })->order('pmg_id asc')->get_all([
            'pmg_mat_id'    => $id
        ]);
        $this->success('', $out);
    }

    /**
     * 材料保存
     * @return [type] [description]
     */
    public function save_action () {
        $this->check_login();
        $tab = OBJ('material_table');
        $mat = $this->data['row'];
        $mat['mat_id'] = (int)$mat['mat_id'];
        $mat['mat_atime'] = REQUEST_TIME;
        $mat['mat_stocks'] = 0;
        $mat['mat_buyer_id'] = $this->login['admin_id'];
        $mat['mat_status'] = material_helper::STATUS_ON_SALE;
        $mat['mat_min_price'] = 0;
        $mat['mat_max_price'] = 0;
        if ($tab->load($mat)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $mat['mat_id'] = $mat['mat_id'] ?: $ret['row_id'];
                material_helper::add_goods($mat, $this->data['attr_key'], $this->data['attr_val']);
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }

    /**
     * 材料列表
     * @return [type] [description]
     */
    public function list_action () {
        $out = [];
        $tab = OBJ('material_table');
        $brand_ids = [];
        $admin_ids = [];

        // 分页配置
        $out['attrs']['paging'] = (new paging_helper($tab, $this->data['pn']))->to_array();

        // 材料列表
        $out['list'] = $tab->order('mat_id desc')->map(function ($row) use (&$brand_ids, &$admin_ids) {
            $admin_ids[$row['mat_buyer_id']] = 0;
            $brand_ids[$row['mat_brand_id']] = 0;
            return $row;
        })->get_all();

        // 相关分类
        $out['attrs']['cat'] = category_helper::get_rows(category_helper::TYPE_MATERIAL, true);

        // 相关品牌
        $out['attrs']['brands'] = OBJ('brand_table')->akey('pb_id')->get_all([
            'pb_id'  => array_keys($brand_ids ?: [0])
        ]);

        // 相关渠道负责人
        $out['attrs']['admins'] = OBJ('admin_table')->akey('admin_id')->fields('admin_id,admin_nick')->get_all([
            'admin_id'  => array_keys($admin_ids ?: [0])
        ]);

        // 附件地址
        $out['attrs']['upload_url'] = UPLOAD_URL;
        $out['attrs']['image_url'] = IMAGE_URL;

        $this->success('', $out);
    }

    /**
     * 材料删除
     * @return [type] [description]
     */
    public function del_action () {
        $this->check_login();
        $id = intval($this->data['id']);
        $tab = OBJ('material_table');
        $mat = $tab->get($id) ?: [];

        if (!empty($mat)) {
            if (preg_match(filter::$rules['file_path'], $mat['mat_cover']) 
                && file_exists(UPLOAD_PATH . $mat['mat_cover'])) {
                unlink(UPLOAD_PATH . $mat['mat_cover']);
            }
            $tab->delete([
                'mat_id'   => $id
            ]);
            OBJ('material_goods_table')->delete([
                'pmg_mat_id'   => $id
            ]);
            admin_helper::add_log($this->login['admin_id'], 'mat/del', '3',
                    '删除材料[' . $id . '@' . $mat['mat_name'] . ']');
            $this->success('删除成功');
        }
        $this->failure('删除失败');
    }

}
