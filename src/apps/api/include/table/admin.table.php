<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 管理员 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class admin_table extends table {

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
        'admin_id' => [
            'name'               => 'admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '用户编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_account' => [
            'name'               => 'admin_account',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '登录账号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_passwd' => [
            'name'               => 'admin_passwd',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '登录密码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_salt' => [
            'name'               => 'admin_salt',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '随机盐值',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_mobile' => [
            'name'               => 'admin_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '手机号码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_email' => [
            'name'               => 'admin_email',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '邮箱地址',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'admin_wechat' => [
            'name'               => 'admin_wechat',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '绑定的微信号',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'admin_nick' => [
            'name'               => 'admin_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '真实姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_group_id' => [
            'name'               => 'admin_group_id',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '所属用户组',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'admin_type' => [
            'name'               => 'admin_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '管理类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_date_add' => [
            'name'               => 'admin_date_add',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '注册时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'admin_date_login' => [
            'name'               => 'admin_date_login',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '最后登录',
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
        'key' => 'admin_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'admin_id'        => 0,
        'admin_account'   => '',
        'admin_passwd'    => '',
        'admin_salt'      => '',
        'admin_mobile'    => '',
        'admin_email'     => '',
        'admin_wechat'    => '',
        'admin_nick'      => '',
        'admin_group_id'  => 1,
        'admin_type'      => 1,
        'admin_date_add'  => 0,
        'admin_date_login'=> 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'admin_id'        => ['re\rgx\filter', 'int'],
        'admin_account'   => ['re\rgx\filter', 'char'],
        'admin_passwd'    => ['re\rgx\filter', 'char'],
        'admin_salt'      => ['re\rgx\filter', 'char'],
        'admin_mobile'    => ['re\rgx\filter', 'char'],
        'admin_email'     => ['re\rgx\filter', 'char'],
        'admin_wechat'    => ['re\rgx\filter', 'char'],
        'admin_nick'      => ['re\rgx\filter', 'char'],
        'admin_group_id'  => ['re\rgx\filter', 'int'],
        'admin_type'      => ['re\rgx\filter', 'int'],
        'admin_date_add'  => ['re\rgx\filter', 'int'],
        'admin_date_login'=> ['re\rgx\filter', 'int'],
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