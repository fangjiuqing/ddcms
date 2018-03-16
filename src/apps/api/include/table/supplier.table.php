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
        'sup_cat_id' => [
            'name'               => 'sup_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '供应商类型',
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
        'sup_adate'   => 0,
        'sup_cat_id'  => 0,
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
        'sup_adate'   => ['re\rgx\filter', 'int'],
        'sup_cat_id'  => ['re\rgx\filter', 'int'],
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