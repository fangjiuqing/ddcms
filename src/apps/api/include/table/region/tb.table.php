<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_region_tb 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-29 16:23:18
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api --all
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class region_tb_table extends table {

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
        'region_id' => [
            'name'               => 'region_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '记录编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'region_code' => [
            'name'               => 'region_code',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => '数字代码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'region_parent' => [
            'name'               => 'region_parent',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => '所属父级',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'region_name' => [
            'name'               => 'region_name',
            'type'               => 'char',
            'field_type'         => 'char',
            'min'                => 0,
            'max'                => 50,
            'label'              => '地区名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'region_level' => [
            'name'               => 'region_level',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '地区级别',
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
        'key' => 'region_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'region_id'       => 0,
        'region_code'     => 0,
        'region_parent'   => 0,
        'region_name'     => '',
        'region_level'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'region_id'       => ['re\rgx\filter', 'int'],
        'region_code'     => ['re\rgx\filter', 'int'],
        'region_parent'   => ['re\rgx\filter', 'int'],
        'region_name'     => ['re\rgx\filter', 'char'],
        'region_level'    => ['re\rgx\filter', 'int'],
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