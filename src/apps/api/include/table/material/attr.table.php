<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_material_attr 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-30 14:39:05
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class material_attr_table extends table {

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
        'pma_id' => [
            'name'               => 'pma_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => ' 编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pma_name' => [
            'name'               => 'pma_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '属性名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pma_cat_id' => [
            'name'               => 'pma_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属分类',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'pma_sort' => [
            'name'               => 'pma_sort',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '排序值',
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
        'key' => 'pma_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'pma_id'      => 0,
        'pma_name'    => '',
        'pma_cat_id'  => 0,
        'pma_sort'    => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'pma_id'      => ['re\rgx\filter', 'int'],
        'pma_name'    => ['re\rgx\filter', 'char'],
        'pma_cat_id'  => ['re\rgx\filter', 'int'],
        'pma_sort'    => ['re\rgx\filter', 'int'],
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