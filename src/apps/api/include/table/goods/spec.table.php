<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_goods_spec 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-21 11:32:25
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_spec_table extends table {

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
        'gs_id' => [
            'name'               => 'gs_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '规格ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_attr' => [
            'name'               => 'gs_attr',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '规格描述',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_goods_id' => [
            'name'               => 'gs_goods_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_price' => [
            'name'               => 'gs_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '商品售价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_price_source' => [
            'name'               => 'gs_price_source',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '吊牌价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_price_cost' => [
            'name'               => 'gs_price_cost',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '成本价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_cover' => [
            'name'               => 'gs_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '商品封面',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gs_stock' => [
            'name'               => 'gs_stock',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '库存数',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'gs_stat_sale' => [
            'name'               => 'gs_stat_sale',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '已售出',
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
        'key' => 'gs_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'gs_id'           => 0,
        'gs_attr'         => '',
        'gs_goods_id'     => 0,
        'gs_price'        => 0.00,
        'gs_price_source' => 0.00,
        'gs_price_cost'   => 0.00,
        'gs_cover'        => '',
        'gs_stock'        => 0,
        'gs_stat_sale'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'gs_id'           => ['re\rgx\filter', 'int'],
        'gs_attr'         => ['re\rgx\filter', 'char'],
        'gs_goods_id'     => ['re\rgx\filter', 'int'],
        'gs_price'        => ['re\rgx\filter', 'float'],
        'gs_price_source' => ['re\rgx\filter', 'float'],
        'gs_price_cost'   => ['re\rgx\filter', 'float'],
        'gs_cover'        => ['re\rgx\filter', 'char'],
        'gs_stock'        => ['re\rgx\filter', 'int'],
        'gs_stat_sale'    => ['re\rgx\filter', 'int'],
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