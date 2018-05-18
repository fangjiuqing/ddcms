<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 客户预约 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-02 18:06:26
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php ./rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class customer_order_table extends table {

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
        'pco_id' => [
            'name'               => 'pco_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '预约编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_type' => [
            'name'               => 'pco_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '预约类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_stime' => [
            'name'               => 'pco_stime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '预约开始时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_etime' => [
            'name'               => 'pco_etime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '预约结束时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_pc_id' => [
            'name'               => 'pco_pc_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客户',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_admin_id' => [
            'name'               => 'pco_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_atime' => [
            'name'               => 'pco_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pco_sms_send' => [
            'name'               => 'pco_sms_send',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 255,
            'label'              => '是否发送短信',
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
        'key' => 'pco_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pco_id'      => 0,
        'pco_type'    => 0,
        'pco_stime'   => 0,
        'pco_etime'   => 0,
        'pco_pc_id'   => 0,
        'pco_admin_id'=> 0,
        'pco_atime'   => 0,
        'pco_sms_send'=> 0
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pco_id'      => ['re\rgx\filter', 'int'],
        'pco_type'    => ['re\rgx\filter', 'int'],
        'pco_stime'   => ['re\rgx\filter', 'int'],
        'pco_etime'   => ['re\rgx\filter', 'int'],
        'pco_pc_id'   => ['re\rgx\filter', 'int'],
        'pco_admin_id'=> ['re\rgx\filter', 'int'],
        'pco_atime'   => ['re\rgx\filter', 'int'],
        'pco_sms_send' => ['re\rgx\filter', 'int'],
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
