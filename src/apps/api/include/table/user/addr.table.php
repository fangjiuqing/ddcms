<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_user_addr 表模型
  + ----------------------------------------------------------------
  + @date 2018-06-05 10:43:42
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class user_addr_table extends table {

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
        'ua_id' => [
            'name'               => 'ua_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '地址编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_name' => [
            'name'               => 'ua_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 50,
            'label'              => '地址名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_user_id' => [
            'name'               => 'ua_user_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属用户',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_consignee' => [
            'name'               => 'ua_consignee',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 60,
            'label'              => '收货人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_email' => [
            'name'               => 'ua_email',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 60,
            'label'              => '邮箱',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_region0' => [
            'name'               => 'ua_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在省份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_region1' => [
            'name'               => 'ua_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在城市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_region2' => [
            'name'               => 'ua_region2',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在区县',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_region3' => [
            'name'               => 'ua_region3',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在街道',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_addr' => [
            'name'               => 'ua_addr',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 120,
            'label'              => '详细地址',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_zipcode' => [
            'name'               => 'ua_zipcode',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 60,
            'label'              => '邮编',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_mobile' => [
            'name'               => 'ua_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 60,
            'label'              => '电话号码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ua_sort' => [
            'name'               => 'ua_sort',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '排序值',
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
        'key' => 'ua_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'ua_id'       => 0,
        'ua_name'     => '',
        'ua_user_id'  => 0,
        'ua_consignee'=> '',
        'ua_email'    => '',
        'ua_region0'  => 0,
        'ua_region1'  => 0,
        'ua_region2'  => 0,
        'ua_region3'  => 0,
        'ua_addr'     => '',
        'ua_zipcode'  => '',
        'ua_mobile'   => '',
        'ua_sort'     => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'ua_id'       => ['re\rgx\filter', 'int'],
        'ua_name'     => ['re\rgx\filter', 'char'],
        'ua_user_id'  => ['re\rgx\filter', 'int'],
        'ua_consignee'=> ['re\rgx\filter', 'char'],
        'ua_email'    => ['re\rgx\filter', 'char'],
        'ua_region0'  => ['re\rgx\filter', 'int'],
        'ua_region1'  => ['re\rgx\filter', 'int'],
        'ua_region2'  => ['re\rgx\filter', 'int'],
        'ua_region3'  => ['re\rgx\filter', 'int'],
        'ua_addr'     => ['re\rgx\filter', 'char'],
        'ua_zipcode'  => ['re\rgx\filter', 'char'],
        'ua_mobile'   => ['re\rgx\filter', 'char'],
        'ua_sort'     => ['re\rgx\filter', 'int'],
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