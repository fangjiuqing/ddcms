<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_brand 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class brand_table extends table {

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
        'pb_id' => [
            'name'               => 'pb_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '品牌编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pb_name' => [
            'name'               => 'pb_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '品牌名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pb_sup_id' => [
            'name'               => 'pb_sup_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属供应商',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pb_type' => [
            'name'               => 'pb_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '所属类别',
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
        'key' => 'pb_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pb_id'       => 0,
        'pb_name'     => '',
        'pb_sup_id'   => 0,
        'pb_type'     => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pb_id'       => ['re\rgx\filter', 'int'],
        'pb_name'     => ['re\rgx\filter', 'char'],
        'pb_sup_id'   => ['re\rgx\filter', 'int'],
        'pb_type'     => ['re\rgx\filter', 'int'],
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