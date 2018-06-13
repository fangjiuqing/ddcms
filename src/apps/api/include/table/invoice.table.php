<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_invoice 表模型
  + ----------------------------------------------------------------
  + @date 2018-06-12 14:36:41
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class invoice_table extends table {

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
        'in_id' => [
            'name'               => 'in_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '发票id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_type' => [
            'name'               => 'in_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '发票类型: 1纸质发票/2增值税专用发票',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_title_type' => [
            'name'               => 'in_title_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '发票抬头:个人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_title_name' => [
            'name'               => 'in_title_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 125,
            'label'              => '发票抬头详情',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_sid' => [
            'name'               => 'in_sid',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 18,
            'label'              => '纳税人识别号/统一社会信用代码',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'in_addr' => [
            'name'               => 'in_addr',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '公司登记地址',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'in_tel' => [
            'name'               => 'in_tel',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 12,
            'label'              => '注册公司电话',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'in_dbank' => [
            'name'               => 'in_dbank',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '开户银行',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'in_anum' => [
            'name'               => 'in_anum',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '开户行账号',
            'allow_empty_string' => true,
            'allow_null'         => false
        ],
        'in_content' => [
            'name'               => 'in_content',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 512,
            'label'              => '发票内容',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_money' => [
            'name'               => 'in_money',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '发票金额',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_pc_id' => [
            'name'               => 'in_pc_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客户id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_region0' => [
            'name'               => 'in_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '收货地址所在省',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_region1' => [
            'name'               => 'in_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '收货地址所在市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_region2' => [
            'name'               => 'in_region2',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '收货地址所在区',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_address' => [
            'name'               => 'in_address',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '收货详细地址',
            'allow_empty_string' => address,
            'allow_null'         => false
        ],
        'in_receiver' => [
            'name'               => 'in_receiver',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '收货人姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_mobile' => [
            'name'               => 'in_mobile',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '收货人手机号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_email' => [
            'name'               => 'in_email',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '收货人邮箱',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_atime' => [
            'name'               => 'in_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '发票添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_utime' => [
            'name'               => 'in_utime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => 'in_utime',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'in_status' => [
            'name'               => 'in_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '信息更新时间',
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
        'key' => 'in_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'in_id'           => 0,
        'in_type'         => 1,
        'in_title_type'   => 1,
        'in_title_name'   => '',
        'in_sid'          => '',
        'in_addr'         => '',
        'in_tel'          => '',
        'in_dbank'        => '',
        'in_anum'         => '',
        'in_content'      => '',
        'in_money'        => 0.00,
        'in_pc_id'        => 0,
        'in_region0'      => 0,
        'in_region1'      => 0,
        'in_region2'      => 0,
        'in_address'      => '',
        'in_receiver'     => '',
        'in_mobile'       => '',
        'in_email'        => '',
        'in_atime'        => 0,
        'in_utime'        => 0,
        'in_status'       => 1,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'in_id'           => ['re\rgx\filter', 'int'],
        'in_type'         => ['re\rgx\filter', 'int'],
        'in_title_type'   => ['re\rgx\filter', 'int'],
        'in_title_name'   => ['re\rgx\filter', 'char'],
        'in_sid'          => ['re\rgx\filter', 'char'],
        'in_addr'         => ['re\rgx\filter', 'char'],
        'in_tel'          => ['re\rgx\filter', 'char'],
        'in_dbank'        => ['re\rgx\filter', 'char'],
        'in_anum'         => ['re\rgx\filter', 'char'],
        'in_content'      => ['re\rgx\filter', 'char'],
        'in_money'        => ['re\rgx\filter', 'float'],
        'in_pc_id'        => ['re\rgx\filter', 'int'],
        'in_region0'      => ['re\rgx\filter', 'int'],
        'in_region1'      => ['re\rgx\filter', 'int'],
        'in_region2'      => ['re\rgx\filter', 'int'],
        'in_address'      => ['re\rgx\filter', 'char'],
        'in_receiver'     => ['re\rgx\filter', 'char'],
        'in_mobile'       => ['re\rgx\filter', 'char'],
        'in_email'        => ['re\rgx\filter', 'char'],
        'in_atime'        => ['re\rgx\filter', 'int'],
        'in_utime'        => ['re\rgx\filter', 'int'],
        'in_status'       => ['re\rgx\filter', 'int'],
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
