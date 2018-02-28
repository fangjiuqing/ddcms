<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 小区表 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 17:26:48
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class community_table extends table {

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
        'pco_id' => [
            'name'               => 'pco_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '小区ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_region0' => [
            'name'               => 'pco_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在省份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_region1' => [
            'name'               => 'pco_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在城市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_region2' => [
            'name'               => 'pco_region2',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所有区县',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_name' => [
            'name'               => 'pco_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '小区名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_addr' => [
            'name'               => 'pco_addr',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '详细地址',
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
        'key' => 'pco_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pco_id'      => 0,
        'pco_region0' => 0,
        'pco_region1' => 0,
        'pco_region2' => 0,
        'pco_name'    => '',
        'pco_addr'    => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pco_id'      => ['re\rgx\filter', 'int'],
        'pco_region0' => ['re\rgx\filter', 'int'],
        'pco_region1' => ['re\rgx\filter', 'int'],
        'pco_region2' => ['re\rgx\filter', 'int'],
        'pco_name'    => ['re\rgx\filter', 'char'],
        'pco_addr'    => ['re\rgx\filter', 'char'],
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