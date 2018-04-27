<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 统计表 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-26 16:15:29
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class stat_table extends table {

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
        'stat_id' => [
            'name'               => 'stat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_type' => [
            'name'               => 'stat_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '统计类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_ref_id' => [
            'name'               => 'stat_ref_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '内容ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_year' => [
            'name'               => 'stat_year',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '年份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_month' => [
            'name'               => 'stat_month',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '月份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_day' => [
            'name'               => 'stat_day',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '天',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_adate' => [
            'name'               => 'stat_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_via' => [
            'name'               => 'stat_via',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '来源',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_user_id' => [
            'name'               => 'stat_user_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '用户ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'stat_hash' => [
            'name'               => 'stat_hash',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '用户hash',
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
        'key' => 'stat_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'stat_id'     => 0,
        'stat_type'   => 0,
        'stat_ref_id' => 0,
        'stat_year'   => 0,
        'stat_month'  => 0,
        'stat_day'    => 0,
        'stat_adate'  => 0,
        'stat_via'    => 0,
        'stat_user_id'=> 0,
        'stat_hash'   => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'stat_id'     => ['re\rgx\filter', 'int'],
        'stat_type'   => ['re\rgx\filter', 'int'],
        'stat_ref_id' => ['re\rgx\filter', 'int'],
        'stat_year'   => ['re\rgx\filter', 'int'],
        'stat_month'  => ['re\rgx\filter', 'int'],
        'stat_day'    => ['re\rgx\filter', 'int'],
        'stat_adate'  => ['re\rgx\filter', 'int'],
        'stat_via'    => ['re\rgx\filter', 'int'],
        'stat_user_id'=> ['re\rgx\filter', 'int'],
        'stat_hash'   => ['re\rgx\filter', 'char'],
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