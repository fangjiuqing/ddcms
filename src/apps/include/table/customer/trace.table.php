<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 跟单日志 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 16:35:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/admin
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class customer_trace_table extends table {

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
        'pct_id' => [
            'name'               => 'pct_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => -2147483648,
            'max'                => 2147483647,
            'label'              => '记录ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pct_cs_id' => [
            'name'               => 'pct_cs_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '操作客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pct_cs_nick' => [
            'name'               => 'pct_cs_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '客服姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pct_cus_id' => [
            'name'               => 'pct_cus_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '客户ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pct_memo' => [
            'name'               => 'pct_memo',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '备注信息',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pct_atime' => [
            'name'               => 'pct_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '录入时间',
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
        'key' => 'pct_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pct_id'      => 0,
        'pct_cs_id'   => 0,
        'pct_cs_nick' => '',
        'pct_cus_id'  => 0,
        'pct_memo'    => '',
        'pct_atime'   => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pct_id'      => ['re\rgx\filter', 'int'],
        'pct_cs_id'   => ['re\rgx\filter', 'int'],
        'pct_cs_nick' => ['re\rgx\filter', 'char'],
        'pct_cus_id'  => ['re\rgx\filter', 'int'],
        'pct_memo'    => ['re\rgx\filter', 'char'],
        'pct_atime'   => ['re\rgx\filter', 'int'],
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