<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_shipping 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-29 16:23:19
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api --all
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class shipping_table extends table {

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
        'shipping_id' => [
            'name'               => 'shipping_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '配送ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'shipping_name' => [
            'name'               => 'shipping_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '配送名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'shipping_price' => [
            'name'               => 'shipping_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '配送价格',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'shipping_free' => [
            'name'               => 'shipping_free',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '免费额度',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'shipping_regions' => [
            'name'               => 'shipping_regions',
            'type'               => 'char',
            'field_type'         => 'text',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '配送区域',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'shipping_status' => [
            'name'               => 'shipping_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '记录状态',
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
        'key' => 'shipping_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'shipping_id'     => 0,
        'shipping_name'   => '',
        'shipping_price'  => 0.00,
        'shipping_free'   => 0.00,
        'shipping_regions'=> '',
        'shipping_status' => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'shipping_id'     => ['re\rgx\filter', 'int'],
        'shipping_name'   => ['re\rgx\filter', 'char'],
        'shipping_price'  => ['re\rgx\filter', 'float'],
        'shipping_free'   => ['re\rgx\filter', 'float'],
        'shipping_regions'=> ['re\rgx\filter', 'char'],
        'shipping_status' => ['re\rgx\filter', 'int'],
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