<?php
namespace re\rgx;

/**
 * 商品管理接口
 */
class store_goods_iface extends ubase_iface {

    /**
     * 商品列表
     * @return [type] [description]
     */
    public function list_action () {
        $tab = OBJ('goods_table');
        $paging = new paging_helper($tab, $this->data['pn'] ?: 1, 12);
        $tab->akey()->order('goods_udate desc');

        $admin_ids = $brand_ids = $supplier_ids = [];

        $out['rows'] = $tab->map(function ($row) use (&$admin_ids, &$brand_ids, &$supplier_ids) {
            $admin_ids[$row['goods_admin_id']] = 0;
            $brand_ids[$row['goods_brand']] = 0;
            $supplier_ids[$row['goods_supplier_id']] = 0;
            $row['status'] = store_helper::$goods_status[$row['goods_status']];
            $row['status_class'] = $row['goods_status'] == store_helper::GOODS_STATUS_SALEOUT ? 'text-danger' : 'text-success';
            $row['spec_show'] = false;
            return $row;
        })->get_all() ?: null;

        // 记录存在
        if($out['rows']) {
            OBJ('goods_spec_table')->map(function ($row) use (&$out) {
                $row['attrs'] = explode('#', substr($row['gs_attr'], 1, -1));
                $out['rows'][$row['gs_goods_id']]['specs'][] = $row;
            })->get_all([
                'gs_goods_id'   => array_keys($out['rows'] ?: [0])
            ]);
        }

        // 分页数据
        $out['attrs']['paging'] = $paging->to_array();

        // 商品类别
        $out['attrs']['categories'] = category_helper::get_rows(category_helper::TYPE_GOODS, true);

        // 相关品牌
        $out['attrs']['brands'] = OBJ('brand_table')->akey()->get_all([
            'pb_id'     => array_keys($brand_ids ?: [0])
        ]);

        // 相关供应商
        $out['attrs']['suppliers'] = OBJ('supplier_table')->akey()->get_all([
            'sup_id'     => array_keys($supplier_ids ?: [0])
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
     * 获取商品详情
     * @return [type] [description]
     */
    public function get_action () {
        $out = [];
        $goods = OBJ('goods_table')->get((int)$this->data['id']);
        if ($goods) {
            $goods['goods_supplier_id'] = OBJ('supplier_table')->fields('sup_id,sup_realname')->get(
                (int)$goods['goods_supplier_id']
            );
            $goods['goods_cover_url'] = UPLOAD_URL . $goods['goods_cover'];
            $base_attrs = store_helper::get_attrs($goods['goods_type_id'], 1);
            $filter_attrs = store_helper::get_attrs($goods['goods_type_id'], 2);
            $specs = OBJ('goods_spec_table')->akey()->map(function ($row) {
                return [
                    'id'        => $row['gs_id'],
                    'sale'      => $row['gs_stat_sale'],
                    '0cover'    => $row['gs_cover'],
                    '0cover_url'=> UPLOAD_URL . $row['gs_cover'],
                    'stocks'    => $row['gs_stock'],
                    'price_cost'    => $row['gs_price_cost'],
                    'price_sale'    => $row['gs_price'],
                    'status'    => $row['gs_status'],
                    'status_lab'    => store_goods_helper::$spec_status[$row['gs_status']],
                ];
            })->get_all([
                'gs_goods_id'   => $goods['goods_id']
            ]);
            OBJ('goods_spec_attr_table')->map(function ($g) use (&$base_attrs, &$specs) {
                // base
                if ($g['gsa_type'] == '1') {
                    $base_attrs[$g['gsa_attr_id']]['value'] = $g['gas_value'];
                }
                else if ($g['gsa_type'] == '2') {
                    $specs[$g['gsa_spec_id']][$g['gsa_attr_id']] = $g['gas_value'];
                }
                return null;
            })->get_all([
                'gsa_goods_id'  => $goods['goods_id']
            ]);
            $out['specs'] = $specs;
            $out['attrs'] = $base_attrs;
        }
        $out['row'] = $goods ?: null;
        $out['row']['goods_desc']   = filter::json_unecsape(OBJ('goods_desc_table')->get(['gd_id' => (int)
            $this->data['id']])['gd_desc']);
        $out['brands'] = OBJ('brand_table')->get_all() ?: null;
        $out['categories'] = category_helper::get_options(category_helper::TYPE_GOODS, 0, 0);
        $out['types'] = store_helper::get_goods_types(false, true);
        $out['status'] = store_helper::$goods_status;
        $out['spec_status'] = store_goods_helper::$spec_status;
        $this->success('', $out);
    }

    /**
     * 商品保存
     * @return [type] [description]
     */
    public function save_action () {
        $goods = $this->data['goods'];
        $specs = $this->data['specs'];
        $attrs = $this->data['attrs'];

        $goods['goods_supplier_id'] = is_array($goods['goods_supplier_id']) ? $goods['goods_supplier_id']['sup_id'] : 0;

        // 输入验证
        $this->verify([
            'goods_name' => [
                'msg'  => '请输入商品名称',
                'rule' => filter::$rules['require']
            ],
            'goods_cat_id' => [
                'msg'  => '请选择商品分类',
                'rule' => function ($v) {
                    return filter::is_positive_int($v);
                }
            ],
            'goods_supplier_id' => [
                'msg'  => '请选择所属供应商',
                'rule' => function ($v) {
                    return filter::is_positive_int($v);
                }
            ],
            'goods_brand' => [
                'msg'  => '请选择所属品牌',
                'rule' => function ($v) {
                    return filter::is_positive_int($v);
                }
            ],
            'goods_status' => [
                'msg'  => '请选择商品上下架状态',
                'rule' => function ($v) {
                    return filter::is_positive_int($v);
                }
            ],
            'goods_cover' => [
                'msg'  => '请上传商品封面图片',
                'rule' => filter::$rules['require']
            ],
        ], $goods);

        $attr_list = store_helper::get_attrs($goods['goods_type_id']);

        // 商品规格输入校验
        if (empty($specs) || !is_array($specs)) {
            $this->failure('至少添加一个商品规格');
        }
        foreach ((array)$specs as $v) {
            $this->verify([
                'price_cost' => [
                    'msg'  => '请输入成本价',
                    'rule' => function ($v) {
                        return filter::is_positive_float($v);
                    }
                ],
                'price_sale' => [
                    'msg'  => '请输入售价',
                    'rule' => function ($v) {
                        return filter::is_positive_float($v);
                    }
                ],
                '0cover' => [
                    'msg'  => '请上传规格商品封面图片',
                    'rule' => filter::$rules['require']
                ],
            ], $v);

            foreach ($v as $key => $val) {
                // 属性记录
                if (preg_match('/^\d+$/', $key)) {
                    if (!isset($attr_list[$key])) {
                        $this->failure("无效的商品规格 {$val}");
                    }
                    if ($attr_list[$key]['input_type'] == 'select' 
                        && !in_array($val, $attr_list[$key]['values'])) {
                        $this->failure("无效的{$attr_list[$key]['name']}取值 {$val}");
                    }
                }
            }
            break;
        }

        $goods['goods_id'] = intval($goods['goods_id']);
        $goods['goods_admin_id'] = $this->login['admin_id'];
        $goods['goods_price'] = 0;
        $goods['goods_stock'] = 0;
        $goods['goods_keywords'] = '';
        $goods['goods_adate'] = (int)$goods['goods_adate'] ?: REQUEST_TIME;
        $goods['goods_udate'] = REQUEST_TIME;
        $goods['goods_stat_view'] = (int)$goods['goods_stat_view'] ?: 0;
        $goods['goods_stat_sale'] = (int)$goods['goods_stat_sale'] ?: 0;
        $goods['goods_stat_count'] = 0;
        $goods_tab = OBJ('goods_table');
        if (!$goods_tab->load($goods)) {
            $this->failure($goods_tab->get_error_desc());
        }

        $ret = $goods_tab->save($goods);
        if ($ret['code'] !== 0) {
            $this->failure($ret['msg']);
        }

        $goods['goods_id'] = $goods['goods_id'] ?: $ret['row_id'];

        $spce_desc['gd_id']   = $goods['goods_id'];
        $spce_desc['gd_desc']   = filter::html($goods['goods_desc']);
        if (!OBJ('goods_desc_table')->load($spce_desc)) {
            $this->failure($goods_tab->get_error_desc());
        }
    
        $ret = OBJ('goods_desc_table')->save($goods);
        if ($ret['code'] !== 0) {
            $this->failure($ret['msg']);
        }
        
        // 商品属性
        $base_attrs = $filter_attrs = [];
        foreach ((array)$attrs as $k => $v) {
            $base_attrs[] = [
                'gsa_attr_id'   => $v['id'],
                'gsa_goods_id'  => $goods['goods_id'],
                'gsa_spec_id'   => 0,
                'gsa_type'      => 1, // 普通属性; 2 为筛选属性
                'gas_label'     => $attr_list[$v['id']]['name'],
                'gas_value'     => $v['value']
            ];
        }
        // 入库
        store_goods_helper::add_base_attrs($goods['goods_id'], $base_attrs);

        $gstab = OBJ('goods_spec_table');
        // 商品规格
        foreach ((array)$specs as $spec_key => $spec) {
            $goods['goods_price'] = $goods['goods_price'] ? 
                    min($goods['goods_price'], $spec['price_sale']) : $spec['price_sale'];
            $goods['goods_stock'] += $spec['stocks'];
            $goods['goods_stat_count'] += 1;
            $row = [
                'gs_id'             => (int)$spec['id'],
                'gs_attr'           => [],
                'gs_goods_id'       => $goods['goods_id'],
                'gs_cover'          => $spec['0cover'],
                'gs_price'          => floatval($spec['price_sale']),
                'gs_price_source'   => floatval($spec['price_sale']),
                'gs_price_cost'     => floatval($spec['price_cost']),
                'gs_stock'          => $spec['stocks'],
                'gs_stat_sale'      => (int)$spec['sale'],
                'gs_status'         => (int)$spec['status'] ?: store_goods_helper::NS_STATUS,
            ];
            if ($row['gs_price'] <= 0) {
                store_goods_helper::remove($goods['goods_id']);
                $this->failure("请输入有效的商品售价");
            }
            if ($row['gs_price_cost'] <= 0) {
                store_goods_helper::remove($goods['goods_id']);
                $this->failure("请输入有效的成本价");
            }
            if (empty($row['gs_cover'])) {
                store_goods_helper::remove($goods['goods_id']);
                $this->failure("请上传商品封面图");
            }

            foreach ($spec as $k => $v) {
                if (filter::is_positive_int($k)) {
                    if ($attr_list[$k]['input_type'] == 'select' 
                        && !in_array($v, $attr_list[$k]['values'])) {
                        store_goods_helper::remove($goods['goods_id']);
                        $this->failure("无效的{$attr_list[$k]['name']}规格取值 : {$v}");
                    }
                    $row['gs_attr'][] = "{$attr_list[$k]['name']}:{$v}";
                    $row['attrs'][] = [
                        'gsa_attr_id'   => $k,
                        'gsa_goods_id'  => $goods['goods_id'],
                        'gsa_spec_id'   => 0,
                        'gsa_type'      => 2,
                        'gas_label'     => $attr_list[$k]['name'],
                        'gas_value'     => $v
                    ];
                }
            }
            $row['gs_attr'] = '#' . join("#", $row['gs_attr']) . '#';
            if ($gstab->load($row)) {
                $result = $gstab->save();
                if ($result['code'] === 0) {
                    $row['gs_id'] = $row['gs_id'] ?: $result['row_id'];
                    store_goods_helper::add_filter_attrs($goods['goods_id'], $row['gs_id'], $row['attrs']);
                }
                else {
                    store_goods_helper::remove($goods['goods_id']);
                    $this->failure('规格入库失败' . $result['msg']);
                }
            }
            else {
                store_goods_helper::remove($goods['goods_id']);
                $this->failure($gstab->get_error_desc());
            }
        }
        $goods_tab->update([
            'goods_id'      => $goods['goods_id'],
            'goods_price'   => $goods['goods_price'],
            'goods_stock'   => $goods['goods_stock'],
            'goods_stat_count'  => $goods['goods_stat_count']
        ]);
        $this->success('操作成功');
    }
}
