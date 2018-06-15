<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 广告表 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-21 16:15:43
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class ad_table extends table {

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
        'ad_id' => [
            'name'               => 'ad_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '广告ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_name' => [
            'name'               => 'ad_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '广告名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_location' => [
            'name'               => 'ad_location',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => 'ad_location',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_status' => [
            'name'               => 'ad_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '广告状态',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_desc' => [
            'name'               => 'ad_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 1024,
            'label'              => '广告内容',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_adate' => [
            'name'               => 'ad_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加日期',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'ad_udate' => [
            'name'               => 'ad_udate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => 'ad_udate',
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
        'key' => 'ad_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'ad_id'       => 0,
        'ad_name'     => '',
        'ad_location' => '',
        'ad_status'   => 0,
        'ad_desc'     => '',
        'ad_adate'    => 0,
        'ad_udate'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'ad_id'       => ['re\rgx\filter', 'int'],
        'ad_name'     => ['re\rgx\filter', 'char'],
        'ad_location' => ['re\rgx\filter', 'char'],
        'ad_status'   => ['re\rgx\filter', 'int'],
        'ad_desc'     => ['re\rgx\filter', 'char'],
        'ad_adate'    => ['re\rgx\filter', 'int'],
        'ad_udate'    => ['re\rgx\filter', 'int'],
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