<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 子商品属性 表模型
  + ----------------------------------------------------------------
  + @date 2018-06-08 14:01:53
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_spec_attr_table extends table {

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
        'gsa_attr_id' => [
            'name'               => 'gsa_attr_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '属性ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gsa_goods_id' => [
            'name'               => 'gsa_goods_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品iD',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gsa_spec_id' => [
            'name'               => 'gsa_spec_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '子商品id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gsa_type' => [
            'name'               => 'gsa_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '属性类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gas_label' => [
            'name'               => 'gas_label',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '属性名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gas_value' => [
            'name'               => 'gas_value',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '属性值',
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
        'key' => ['gsa_attr_id', 'gsa_goods_id', 'gsa_spec_id'],
        'inc' => false
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'gsa_attr_id' => 0,
        'gsa_goods_id'=> 0,
        'gsa_spec_id' => 0,
        'gsa_type'    => 0,
        'gas_label'   => '',
        'gas_value'   => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'gsa_attr_id' => ['re\rgx\filter', 'int'],
        'gsa_goods_id'=> ['re\rgx\filter', 'int'],
        'gsa_spec_id' => ['re\rgx\filter', 'int'],
        'gsa_type'    => ['re\rgx\filter', 'int'],
        'gas_label'   => ['re\rgx\filter', 'char'],
        'gas_value'   => ['re\rgx\filter', 'char'],
    ];

    /*
      +--------------------------
      + 唯一性检测
      +--------------------------
    */
    public $unique_check = [
        ['gsa_attr_id', 'gsa_goods_id', 'gsa_spec_id']
    ];

    /*
      +--------------------------
      + 自定义字段验证规则
      +--------------------------
    */
    public $validate = [];

}