<?php
namespace re\rgx;

/**
 * 材料助手类
 */
class material_helper extends rgx {

    /**
     * 大致材料分类
     * @var [type]
     */
    public static $type = [
        1   => '家具家私',
        2   => '水暖洁具',
        3   => '照明灯具',
        4   => '家具五金',
        5   => '家装主材',
        6   => '建筑建材',
    ];

    /**
     * 空间分类
     * @var [type]
     */
    public static $space = [
        1   => '客厅',
        2   => '卧室',
        3   => '餐厅',
        4   => '厨房',
        5   => '卫生间',
        6   => '阳台',
        7   => '书房',
        8   => '玄关',
        9   => '过道',
        10  => '儿童房',
        11  => '老人房',
        12  => '花园'
    ];

    public static $layout = [
        1   => '背景墙',
        2   => '吊灯',
        3   => '隔断',
        4   => '窗帘',
        5   => '飘窗',
        6   => '榻榻米'
    ];


    const STATUS_SOLD_OUT       = 1;

    const STATUS_ON_SALE        = 2;

    /**
     * 记录状态
     * @var [type]
     */
    public static $status = [
        1   => '下架',
        2   => '在售'
    ];

    /**
     * 添加材料商品
     * @param [type] $mat   [description]
     * @param [type] $attrs [description]
     * @param [type] $rows  [description]
     */
    public static function add_goods ($mat, $attrs, $rows) {
        $id_map = [];
        $atab = OBJ('material_attr_table');
        foreach ((array)$attrs as $k => $v) {
            $row = $atab->get([
                'pma_name'  => $v
            ]);
            if (empty($row)) {
                $ret = $atab->insert([
                    'pma_name'      => $v,
                    'pma_cat_id'    => $mat['mat_cat_id'],
                    'pma_sort'      => 1
                ]);
                if ($ret['code'] === 0) {
                    $row['pma_id'] = $ret['row_id'];
                }
            }
            $id_map[$k] = $row['pma_id'];
        }

        $min_price = 0;
        $max_price = 0;
        $stocks = 0;
        $gtab = OBJ('material_goods_table');
        foreach ((array)$rows as $k => $v) {
            $desc = [];
            $hash = '';
            foreach ((array)$attrs as $key => $val) {
                if (!in_array($key, ['price', 'cost_price', 'stocks'])) {
                    $hash .= $val;
                }
                if (isset($v[$key])) {
                    $desc[] = $val . "=" . $v[$key];
                }
            }
            if (empty($hash)) {
                continue;
            }
            $goods = [
                'pmg_id'            => (int)$v['id'],
                'pmg_mat_id'        => (int)$mat['mat_id'],
                'pmg_cover'         => $v['cover'] ?: '',
                'pmg_price'         => (float)$v['price'],
                'pmg_cost_price'    => (float)$v['cost_price'],
                'pmg_stocks'        => (int)$v['stocks'],
                'pmg_storage_id'    => 0,
                'pmg_desc'          => '#' . join('#', $desc) . '#'
            ];
            if ($goods['pmg_price'] > 0 && $gtab->load($goods)) {
                if ($gtab->save()['code'] === 0) {
                    $stocks += $goods['pmg_stocks'];
                    $min_price = $min_price ? min($min_price, $goods['pmg_price']) : $goods['pmg_price'];
                    $max_price = max($max_price, $goods['pmg_price']);
                }
            }
        }
        OBJ('material_table')->update([
            'mat_id'        => $mat['mat_id'],
            'mat_min_price' => $min_price,
            'mat_max_price' => $max_price
        ]);

    }
}