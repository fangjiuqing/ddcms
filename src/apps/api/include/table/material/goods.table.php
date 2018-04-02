<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_material_goods 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-30 14:39:05
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class material_goods_table extends table {

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
        'pmg_id' => [
            'name'               => 'pmg_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_mat_id' => [
            'name'               => 'pmg_mat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属材料',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_cover' => [
            'name'               => 'pmg_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 48,
            'label'              => '封面',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'pmg_desc' => [
            'name'               => 'pmg_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 1024,
            'label'              => '规格描述',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_price' => [
            'name'               => 'pmg_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 12,
            'max'                => 2,
            'label'              => '售价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_cost_price' => [
            'name'               => 'pmg_cost_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 12,
            'max'                => 2,
            'label'              => '采购价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_stocks' => [
            'name'               => 'pmg_stocks',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '库存',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pmg_storage_id' => [
            'name'               => 'pmg_storage_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在仓库',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
    ];

    /*
      +--------------------------
      + 主键
      +--------------------------
    */
    protected $_primary_key = [
        'key' => 'pmg_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pmg_id'          => 0,
        'pmg_mat_id'      => 0,
        'pmg_cover'       => '',
        'pmg_desc'        => '',
        'pmg_price'       => 0.00,
        'pmg_cost_price'  => 0.00,
        'pmg_stocks'      => 0,
        'pmg_storage_id'  => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pmg_id'          => ['re\rgx\filter', 'int'],
        'pmg_mat_id'      => ['re\rgx\filter', 'int'],
        'pmg_cover'       => ['re\rgx\filter', 'char'],
        'pmg_desc'        => ['re\rgx\filter', 'char'],
        'pmg_price'       => ['re\rgx\filter', 'float'],
        'pmg_cost_price'  => ['re\rgx\filter', 'float'],
        'pmg_stocks'      => ['re\rgx\filter', 'int'],
        'pmg_storage_id'  => ['re\rgx\filter', 'int'],
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