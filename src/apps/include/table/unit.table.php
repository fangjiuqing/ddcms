<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 户型 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 16:35:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/admin
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class unit_table extends table {

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
        'pu_id' => [
            'name'               => 'pu_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '户型ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_co_id' => [
            'name'               => 'pu_co_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在小区',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_name' => [
            'name'               => 'pu_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '户型名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_cover' => [
            'name'               => 'pu_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '户型图片',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_area0' => [
            'name'               => 'pu_area0',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 5,
            'max'                => 2,
            'label'              => '建筑面积',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_area1' => [
            'name'               => 'pu_area1',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 5,
            'max'                => 2,
            'label'              => '使用面积',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_room0' => [
            'name'               => 'pu_room0',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '卧室数量',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_room1' => [
            'name'               => 'pu_room1',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '客厅数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_room2' => [
            'name'               => 'pu_room2',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '卫生间数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_room3' => [
            'name'               => 'pu_room3',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '厨房数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_area_range' => [
            'name'               => 'pu_area_range',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '面积范围',
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
        'key' => 'pu_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pu_id'           => 0,
        'pu_co_id'        => 0,
        'pu_name'         => '',
        'pu_cover'        => '',
        'pu_area0'        => 0.00,
        'pu_area1'        => 0.00,
        'pu_room0'        => 0,
        'pu_room1'        => 0,
        'pu_room2'        => 0,
        'pu_room3'        => 0,
        'pu_area_range'   => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pu_id'           => ['re\rgx\filter', 'int'],
        'pu_co_id'        => ['re\rgx\filter', 'int'],
        'pu_name'         => ['re\rgx\filter', 'char'],
        'pu_cover'        => ['re\rgx\filter', 'char'],
        'pu_area0'        => ['re\rgx\filter', 'float'],
        'pu_area1'        => ['re\rgx\filter', 'float'],
        'pu_room0'        => ['re\rgx\filter', 'int'],
        'pu_room1'        => ['re\rgx\filter', 'int'],
        'pu_room2'        => ['re\rgx\filter', 'int'],
        'pu_room3'        => ['re\rgx\filter', 'int'],
        'pu_area_range'   => ['re\rgx\filter', 'int'],
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