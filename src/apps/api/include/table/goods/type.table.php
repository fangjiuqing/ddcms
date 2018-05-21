<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_goods_type 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-21 11:32:25
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class goods_type_table extends table {

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
        'gt_id' => [
            'name'               => 'gt_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gt_name' => [
            'name'               => 'gt_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '类型名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'gt_type' => [
            'name'               => 'gt_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '所属类别',
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
        'key' => 'gt_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'gt_id'   => 0,
        'gt_name' => '',
        'gt_type' => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'gt_id'   => ['re\rgx\filter', 'int'],
        'gt_name' => ['re\rgx\filter', 'char'],
        'gt_type' => ['re\rgx\filter', 'int'],
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