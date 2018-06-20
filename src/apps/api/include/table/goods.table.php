<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_goods 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-21 11:32:17
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_table extends table {

    /*
      +--------------------------
      + 编码
      +--------------------------
    */
    protected $_charset = 'utf8';

    /*
      +--------------------------
      + 字段
      +--------------------------
    */
    protected $_fields = [
        'goods_id' => [
            'name'               => 'goods_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_name' => [
            'name'               => 'goods_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '商品名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_sn' => [
            'name'               => 'goods_sn',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => 'goods_sn',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_cat_id' => [
            'name'               => 'goods_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属分类',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_price' => [
            'name'               => 'goods_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '商品售价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_supplier_id' => [
            'name'               => 'goods_supplier_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属供应商',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_type_id' => [
            'name'               => 'goods_type_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_stock' => [
            'name'               => 'goods_stock',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '总库存',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'goods_cover' => [
            'name'               => 'goods_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '商品封面',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_keywords' => [
            'name'               => 'goods_keywords',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '关键字',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'goods_adate' => [
            'name'               => 'goods_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_udate' => [
            'name'               => 'goods_udate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '更新时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_admin_id' => [
            'name'               => 'goods_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '操作人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_stat_view' => [
            'name'               => 'goods_stat_view',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '浏览总数',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'goods_stat_sale' => [
            'name'               => 'goods_stat_sale',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '售出总数',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'goods_brand' => [
            'name'               => 'goods_brand',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品品牌',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_unit' => [
            'name'               => 'goods_unit',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 8,
            'label'              => '库存单位',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_stat_count' => [
            'name'               => 'goods_stat_count',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '下属商品数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'goods_status' => [
            'name'               => 'goods_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '商品状态',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
    ];

    /*
      +--------------------------
      + 主键
      +--------------------------
    */
    protected $_primary_key = [
        'key' => 'goods_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'goods_id'            => 0,
        'goods_name'          => '',
        'goods_sn'            => '',
        'goods_cat_id'        => 0,
        'goods_price'         => 0.00,
        'goods_supplier_id'   => 0,
        'goods_type_id'       => 0,
        'goods_stock'         => 0,
        'goods_cover'         => '',
        'goods_keywords'      => '',
        'goods_adate'         => 0,
        'goods_udate'         => 0,
        'goods_admin_id'      => 0,
        'goods_stat_view'     => 0,
        'goods_stat_sale'     => 0,
        'goods_brand'         => 0,
        'goods_unit'          => '',
        'goods_stat_count'    => 0,
        'goods_status'        => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'goods_id'            => ['re\rgx\filter', 'int'],
        'goods_name'          => ['re\rgx\filter', 'char'],
        'goods_sn'            => ['re\rgx\filter', 'char'],
        'goods_cat_id'        => ['re\rgx\filter', 'int'],
        'goods_price'         => ['re\rgx\filter', 'float'],
        'goods_supplier_id'   => ['re\rgx\filter', 'int'],
        'goods_type_id'       => ['re\rgx\filter', 'int'],
        'goods_stock'         => ['re\rgx\filter', 'int'],
        'goods_cover'         => ['re\rgx\filter', 'char'],
        'goods_keywords'      => ['re\rgx\filter', 'char'],
        'goods_adate'         => ['re\rgx\filter', 'int'],
        'goods_udate'         => ['re\rgx\filter', 'int'],
        'goods_admin_id'      => ['re\rgx\filter', 'int'],
        'goods_stat_view'     => ['re\rgx\filter', 'int'],
        'goods_stat_sale'     => ['re\rgx\filter', 'int'],
        'goods_brand'         => ['re\rgx\filter', 'int'],
        'goods_unit'          => ['re\rgx\filter', 'char'],
        'goods_stat_count'    => ['re\rgx\filter', 'int'],
        'goods_status'        => ['re\rgx\filter', 'int'],
    ];

    /*
      +--------------------------
      + 唯一性检测
      +--------------------------
    */
    public $unique_check = [
        
    ];

    /*
      +--------------------------
      + 自定义字段验证规则
      +--------------------------
    */
    public $validate = [];

}
