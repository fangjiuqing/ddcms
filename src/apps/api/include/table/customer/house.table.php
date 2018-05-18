<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_customer_house 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-02 18:06:26
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php ./rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class customer_house_table extends table {

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
        'pch_id' => [
            'name'               => 'pch_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pch_pc_id' => [
            'name'               => 'pch_pc_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客户',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pch_type' => [
            'name'               => 'pch_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '房型',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_mode' => [
            'name'               => 'pch_mode',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '户型',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_style' => [
            'name'               => 'pch_style',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '风格',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_area' => [
            'name'               => 'pch_area',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 5,
            'max'                => 2,
            'label'              => '面积',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_area_use' => [
            'name'               => 'pch_area_use',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 5,
            'max'                => 2,
            'label'              => '使用面积',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_floor' => [
            'name'               => 'pch_floor',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '楼层',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_exists' => [
            'name'               => 'pch_exists',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '是否现房',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_gtime' => [
            'name'               => 'pch_gtime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '拿房时间',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'pch_budget' => [
            'name'               => 'pch_budget',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 5,
            'max'                => 2,
            'label'              => '预算',
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
        'key' => 'pch_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pch_id'      => 0,
        'pch_pc_id'   => 0,
        'pch_type'    => 0,
        'pch_mode'    => 0,
        'pch_style'   => 0,
        'pch_area'    => 0.00,
        'pch_area_use'=> 0.00,
        'pch_floor'   => 0,
        'pch_exists'  => 0,
        'pch_gtime'   => 0,
        'pch_budget'  => 0.00,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pch_id'      => ['re\rgx\filter', 'int'],
        'pch_pc_id'   => ['re\rgx\filter', 'int'],
        'pch_type'    => ['re\rgx\filter', 'int'],
        'pch_mode'    => ['re\rgx\filter', 'int'],
        'pch_style'   => ['re\rgx\filter', 'int'],
        'pch_area'    => ['re\rgx\filter', 'float'],
        'pch_area_use'=> ['re\rgx\filter', 'float'],
        'pch_floor'   => ['re\rgx\filter', 'int'],
        'pch_exists'  => ['re\rgx\filter', 'int'],
        'pch_gtime'   => ['re\rgx\filter', 'int'],
        'pch_budget'  => ['re\rgx\filter', 'float'],
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