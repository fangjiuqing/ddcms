<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 材料 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class material_table extends table {

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
        'mat_id' => [
            'name'               => 'mat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '材料编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_name' => [
            'name'               => 'mat_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '材料名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_cover' => [
            'name'               => 'mat_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '材料封面',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_type' => [
            'name'               => 'mat_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '材料类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_cat_id' => [
            'name'               => 'mat_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属分类',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_brand_id' => [
            'name'               => 'mat_brand_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属品牌',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_buyer_id' => [
            'name'               => 'mat_buyer_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '采购员',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_stocks' => [
            'name'               => 'mat_stocks',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '库存数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_atime' => [
            'name'               => 'mat_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => ' 入库时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_status' => [
            'name'               => 'mat_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '记录状态',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'mat_min_price' => [
            'name'               => 'mat_min_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '最低售价',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'mat_max_price' => [
            'name'               => 'mat_max_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '最高售价',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
    ];

    /*
      +--------------------------
      + 主键
      +--------------------------
    */
    protected $_primary_key = [
        'key' => 'mat_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'mat_id'          => 0,
        'mat_name'        => '',
        'mat_cover'       => '',
        'mat_type'        => 0,
        'mat_cat_id'      => 0,
        'mat_brand_id'    => 0,
        'mat_buyer_id'    => 0,
        'mat_stocks'      => 0,
        'mat_atime'       => 0,
        'mat_status'      => 0,
        'mat_min_price'   => 0.00,
        'mat_max_price'   => 0.00,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'mat_id'          => ['re\rgx\filter', 'int'],
        'mat_name'        => ['re\rgx\filter', 'char'],
        'mat_cover'       => ['re\rgx\filter', 'char'],
        'mat_type'        => ['re\rgx\filter', 'int'],
        'mat_cat_id'      => ['re\rgx\filter', 'int'],
        'mat_brand_id'    => ['re\rgx\filter', 'int'],
        'mat_buyer_id'    => ['re\rgx\filter', 'int'],
        'mat_stocks'      => ['re\rgx\filter', 'int'],
        'mat_atime'       => ['re\rgx\filter', 'int'],
        'mat_status'      => ['re\rgx\filter', 'int'],
        'mat_min_price'   => ['re\rgx\filter', 'float'],
        'mat_max_price'   => ['re\rgx\filter', 'float'],
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