<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 平台用户 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class user_table extends table {

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
        'pu_id' => [
            'name'               => 'pu_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => 'pu_id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_nick' => [
            'name'               => 'pu_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_mobile' => [
            'name'               => 'pu_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '手机号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_passwd' => [
            'name'               => 'pu_passwd',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '登录密码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_salt' => [
            'name'               => 'pu_salt',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '随机盐值',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_atime' => [
            'name'               => 'pu_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pu_ltime' => [
            'name'               => 'pu_ltime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => 'pu_ltime',
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
        'key' => 'pu_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pu_id'       => 0,
        'pu_nick'     => '',
        'pu_mobile'   => '',
        'pu_passwd'   => '',
        'pu_salt'     => '',
        'pu_atime'    => 0,
        'pu_ltime'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pu_id'       => ['re\rgx\filter', 'int'],
        'pu_nick'     => ['re\rgx\filter', 'char'],
        'pu_mobile'   => ['re\rgx\filter', 'char'],
        'pu_passwd'   => ['re\rgx\filter', 'char'],
        'pu_salt'     => ['re\rgx\filter', 'char'],
        'pu_atime'    => ['re\rgx\filter', 'int'],
        'pu_ltime'    => ['re\rgx\filter', 'int'],
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