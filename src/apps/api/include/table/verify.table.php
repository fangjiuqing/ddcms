<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_verify 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-14 10:08:35
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php ./rgx/build.php
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class verify_table extends table {

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
        'verify_id' => [
            'name'               => 'verify_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => 'verify_id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'verify_type' => [
            'name'               => 'verify_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '1代表手机号, 2代表邮箱, 3代表账号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'verify_user_id' => [
            'name'               => 'verify_user_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => '接收人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'verify_mobile' => [
            'name'               => 'verify_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '手机号码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'verify_email' => [
            'name'               => 'verify_email',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '验证邮箱',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'verify_account' => [
            'name'               => 'verify_account',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '要验证的账号',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'verify_desc' => [
            'name'               => 'verify_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '信息内容',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'verify_adate' => [
            'name'               => 'verify_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => '发送日期',
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
        'key' => 'verify_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'verify_id'       => 0,
        'verify_type'     => 0,
        'verify_user_id'  => 0,
        'verify_mobile'   => '',
        'verify_email'    => '',
        'verify_account'  => '',
        'verify_desc'     => '',
        'verify_adate'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'verify_id'       => ['re\rgx\filter', 'int'],
        'verify_type'     => ['re\rgx\filter', 'int'],
        'verify_user_id'  => ['re\rgx\filter', 'int'],
        'verify_mobile'   => ['re\rgx\filter', 'char'],
        'verify_email'    => ['re\rgx\filter', 'char'],
        'verify_account'  => ['re\rgx\filter', 'char'],
        'verify_desc'     => ['re\rgx\filter', 'char'],
        'verify_adate'    => ['re\rgx\filter', 'int'],
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