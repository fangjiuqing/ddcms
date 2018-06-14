<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_goods_desc 表模型
  + ----------------------------------------------------------------
  + @date 2018-06-14 15:11:47
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php table --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_desc_table extends table {

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
        'gd_id' => [
            'name'               => 'gd_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '商品id',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gd_desc' => [
            'name'               => 'gd_desc',
            'type'               => 'char',
            'field_type'         => 'mediumtext',
            'min'                => 0,
            'max'                => 16777215,
            'label'              => '商品描述',
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
        'key' => 'gd_id',
        'inc' => false
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'gd_id'   => 0,
        'gd_desc' => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'gd_id'   => ['re\rgx\filter', 'int'],
        'gd_desc' => ['re\rgx\filter', 'char'],
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
