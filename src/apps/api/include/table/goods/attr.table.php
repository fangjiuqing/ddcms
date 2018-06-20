<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_goods_attr 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-21 11:32:25
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_attr_table extends table {

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
        'ga_id' => [
            'name'               => 'ga_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '属性ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ga_type_id' => [
            'name'               => 'ga_type_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '对应类型ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ga_name' => [
            'name'               => 'ga_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '属性名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ga_input_type' => [
            'name'               => 'ga_input_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '输入类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ga_values' => [
            'name'               => 'ga_values',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 512,
            'label'              => '取值',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'ga_type' => [
            'name'               => 'ga_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '属性类型',
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
        'key' => 'ga_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'ga_id'           => 0,
        'ga_type_id'      => 0,
        'ga_name'         => '',
        'ga_input_type'   => 0,
        'ga_values'       => '',
        'ga_type'         => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'ga_id'           => ['re\rgx\filter', 'int'],
        'ga_type_id'      => ['re\rgx\filter', 'int'],
        'ga_name'         => ['re\rgx\filter', 'char'],
        'ga_input_type'   => ['re\rgx\filter', 'int'],
        'ga_values'       => ['re\rgx\filter', 'char'],
        'ga_type'         => ['re\rgx\filter', 'int'],
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
