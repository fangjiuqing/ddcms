<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 客服表 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 16:35:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/admin
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class customer_service_table extends table {

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
        'pcs_uid' => [
            'name'               => 'pcs_uid',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '客服编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pcs_stat_cus' => [
            'name'               => 'pcs_stat_cus',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '客户数量',
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
        'key' => 'pcs_uid',
        'inc' => false
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pcs_uid'     => 0,
        'pcs_stat_cus'=> 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pcs_uid'     => ['re\rgx\filter', 'int'],
        'pcs_stat_cus'=> ['re\rgx\filter', 'int'],
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