<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 管理日志 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:11:21
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class admin_log_table extends table {

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
        'al_id' => [
            'name'               => 'al_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '日志编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_admin_id' => [
            'name'               => 'al_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属管理',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_action' => [
            'name'               => 'al_action',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '1查看 2编辑 3删除',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_url' => [
            'name'               => 'al_url',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '资源地址',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_year' => [
            'name'               => 'al_year',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '年份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_month' => [
            'name'               => 'al_month',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '月份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_day' => [
            'name'               => 'al_day',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '日',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_adate' => [
            'name'               => 'al_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '具体时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_memo' => [
            'name'               => 'al_memo',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '备注',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'al_ip' => [
            'name'               => 'al_ip',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => 'IP地址',
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
        'key' => 'al_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'al_id'       => 0,
        'al_admin_id' => 0,
        'al_action'   => 0,
        'al_url'      => '',
        'al_year'     => 0,
        'al_month'    => 0,
        'al_day'      => 0,
        'al_adate'    => 0,
        'al_memo'     => '',
        'al_ip'       => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'al_id'       => ['re\rgx\filter', 'int'],
        'al_admin_id' => ['re\rgx\filter', 'int'],
        'al_action'   => ['re\rgx\filter', 'int'],
        'al_url'      => ['re\rgx\filter', 'char'],
        'al_year'     => ['re\rgx\filter', 'int'],
        'al_month'    => ['re\rgx\filter', 'int'],
        'al_day'      => ['re\rgx\filter', 'int'],
        'al_adate'    => ['re\rgx\filter', 'int'],
        'al_memo'     => ['re\rgx\filter', 'char'],
        'al_ip'       => ['re\rgx\filter', 'int'],
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