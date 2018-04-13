<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 供应商会员 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-16 14:33:40
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class supplier_table extends table {

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
        'sup_id' => [
            'name'               => 'sup_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '用户ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_realname' => [
            'name'               => 'sup_realname',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '供应商名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_region0' => [
            'name'               => 'sup_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在省份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_region1' => [
            'name'               => 'sup_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在城市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_region2' => [
            'name'               => 'sup_region2',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在县市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_address' => [
            'name'               => 'sup_address',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '详细地址',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_admin_id' => [
            'name'               => 'sup_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_contact' => [
            'name'               => 'sup_contact',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '联系人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_mobile' => [
            'name'               => 'sup_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '手机号码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_adate' => [
            'name'               => 'sup_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '注册时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_type' => [
            'name'               => 'sup_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '供应商类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'sup_desc' => [
            'name'               => 'sup_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 512,
            'label'              => '简介',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'sup_wechat' => [
            'name'               => 'sup_wechat',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '微信',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'sup_qq' => [
            'name'               => 'sup_qq',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => 'QQ',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'sup_email' => [
            'name'               => 'sup_email',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '邮箱',
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
        'key' => 'sup_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'sup_id'      => 0,
        'sup_realname'=> '',
        'sup_region0' => 0,
        'sup_region1' => 0,
        'sup_region2' => 0,
        'sup_address' => '',
        'sup_admin_id'=> 0,
        'sup_contact' => '',
        'sup_mobile'  => '',
        'sup_adate'   => 0,
        'sup_type'    => 0,
        'sup_desc'    => '',
        'sup_wechat'  => '',
        'sup_qq'      => '',
        'sup_email'   => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'sup_id'      => ['re\rgx\filter', 'int'],
        'sup_realname'=> ['re\rgx\filter', 'char'],
        'sup_region0' => ['re\rgx\filter', 'int'],
        'sup_region1' => ['re\rgx\filter', 'int'],
        'sup_region2' => ['re\rgx\filter', 'int'],
        'sup_address' => ['re\rgx\filter', 'char'],
        'sup_admin_id'=> ['re\rgx\filter', 'int'],
        'sup_contact' => ['re\rgx\filter', 'char'],
        'sup_mobile'  => ['re\rgx\filter', 'char'],
        'sup_adate'   => ['re\rgx\filter', 'int'],
        'sup_type'    => ['re\rgx\filter', 'int'],
        'sup_desc'    => ['re\rgx\filter', 'char'],
        'sup_wechat'  => ['re\rgx\filter', 'char'],
        'sup_qq'      => ['re\rgx\filter', 'char'],
        'sup_email'   => ['re\rgx\filter', 'char'],
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