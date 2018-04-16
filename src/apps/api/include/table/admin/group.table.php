<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 权限组 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-16 14:49:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class admin_group_table extends table {

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
        'pag_id' => [
            'name'               => 'pag_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pag_name' => [
            'name'               => 'pag_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '组名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pag_details' => [
            'name'               => 'pag_details',
            'type'               => 'char',
            'field_type'         => 'text',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '权限配置',
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
        'key' => 'pag_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pag_id'      => 0,
        'pag_name'    => '',
        'pag_details' => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pag_id'      => ['re\rgx\filter', 'int'],
        'pag_name'    => ['re\rgx\filter', 'char'],
        'pag_details' => ['re\rgx\filter', 'char'],
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