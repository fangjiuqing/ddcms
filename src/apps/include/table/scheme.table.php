<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 方案 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 16:35:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/admin
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class scheme_table extends table {

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
        'ps_id' => [
            'name'               => 'ps_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '方案编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_name' => [
            'name'               => 'ps_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 45,
            'label'              => '方案名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_cus_id' => [
            'name'               => 'ps_cus_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客户',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_cs_id' => [
            'name'               => 'ps_cs_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_atime' => [
            'name'               => 'ps_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '创建时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_utime' => [
            'name'               => 'ps_utime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '更新时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ps_total' => [
            'name'               => 'ps_total',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 12,
            'max'                => 2,
            'label'              => '方案价格',
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
        'key' => 'ps_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'ps_id'       => 0,
        'ps_name'     => '',
        'ps_cus_id'   => 0,
        'ps_cs_id'    => 0,
        'ps_atime'    => 0,
        'ps_utime'    => 0,
        'ps_total'    => 0.00,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'ps_id'       => ['re\rgx\filter', 'int'],
        'ps_name'     => ['re\rgx\filter', 'char'],
        'ps_cus_id'   => ['re\rgx\filter', 'int'],
        'ps_cs_id'    => ['re\rgx\filter', 'int'],
        'ps_atime'    => ['re\rgx\filter', 'int'],
        'ps_utime'    => ['re\rgx\filter', 'int'],
        'ps_total'    => ['re\rgx\filter', 'float'],
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