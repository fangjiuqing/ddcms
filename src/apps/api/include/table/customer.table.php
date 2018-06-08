<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 客户 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class customer_table extends table {

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
        'pc_id' => [
            'name'               => 'pc_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '客户ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_sn' => [
            'name'               => 'pc_sn',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '客户编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_sid' => [
            'name'               => 'pc_sid',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 18,
            'label'              => '身份证',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_nick' => [
            'name'               => 'pc_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '客户姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_mobile' => [
            'name'               => 'pc_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '手机号码',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_status' => [
            'name'               => 'pc_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '客户状态',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_adm_id' => [
            'name'               => 'pc_adm_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_adm_nick' => [
            'name'               => 'pc_adm_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '客服姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_atime' => [
            'name'               => 'pc_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_utime' => [
            'name'               => 'pc_utime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '最近更新',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_via' => [
            'name'               => 'pc_via',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '客户来源',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_status_del' => [
            'name'               => 'pc_status_del',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '删除状态',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_region0' => [
            'name'               => 'pc_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在省份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_region1' => [
            'name'               => 'pc_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在城市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_region2' => [
            'name'               => 'pc_region2',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在区县',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_region3' => [
            'name'               => 'pc_region3',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => 'pc_region3',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_addr' => [
            'name'               => 'pc_addr',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '详细地址',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_co_id' => [
            'name'               => 'pc_co_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所在小区',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_gender' => [
            'name'               => 'pc_gender',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '性别',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_memo' => [
            'name'               => 'pc_memo',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '备注',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pc_score' => [
            'name'               => 'pc_score',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '成功率评分',
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
        'key' => 'pc_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pc_id'           => 0,
        'pc_sn'           => '',
        'pc_sid'          => '',
        'pc_nick'         => '',
        'pc_mobile'       => '',
        'pc_status'       => 0,
        'pc_adm_id'       => 0,
        'pc_adm_nick'     => '',
        'pc_atime'        => 0,
        'pc_utime'        => 0,
        'pc_via'          => 0,
        'pc_status_del'   => 0,
        'pc_region0'      => 0,
        'pc_region1'      => 0,
        'pc_region2'      => 0,
        'pc_region3'      => 0,
        'pc_addr'         => '',
        'pc_co_id'        => 0,
        'pc_gender'       => 0,
        'pc_memo'         => '',
        'pc_score'        => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pc_id'           => ['re\rgx\filter', 'int'],
        'pc_sn'           => ['re\rgx\filter', 'char'],
        'pc_sid'          => ['re\rgx\filter', 'char'],
        'pc_nick'         => ['re\rgx\filter', 'char'],
        'pc_mobile'       => ['re\rgx\filter', 'char'],
        'pc_status'       => ['re\rgx\filter', 'int'],
        'pc_adm_id'       => ['re\rgx\filter', 'int'],
        'pc_adm_nick'     => ['re\rgx\filter', 'char'],
        'pc_atime'        => ['re\rgx\filter', 'int'],
        'pc_utime'        => ['re\rgx\filter', 'int'],
        'pc_via'          => ['re\rgx\filter', 'int'],
        'pc_status_del'   => ['re\rgx\filter', 'int'],
        'pc_region0'      => ['re\rgx\filter', 'int'],
        'pc_region1'      => ['re\rgx\filter', 'int'],
        'pc_region2'      => ['re\rgx\filter', 'int'],
        'pc_region3'      => ['re\rgx\filter', 'int'],
        'pc_addr'         => ['re\rgx\filter', 'char'],
        'pc_co_id'        => ['re\rgx\filter', 'int'],
        'pc_gender'       => ['re\rgx\filter', 'int'],
        'pc_memo'         => ['re\rgx\filter', 'char'],
        'pc_score'        => ['re\rgx\filter', 'int'],
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