<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 商品分类表 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-05 11:05:11
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class category_table extends table {

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
        'cat_id' => [
            'name'               => 'cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => 'ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_name' => [
            'name'               => 'cat_name',
            'type'               => 'char',
            'field_type'         => 'char',
            'min'                => 0,
            'max'                => 64,
            'label'              => '类别名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_parent' => [
            'name'               => 'cat_parent',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属类别',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_sort' => [
            'name'               => 'cat_sort',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '排序值',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_user_id' => [
            'name'               => 'cat_user_id',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '所属用户 ',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_paths' => [
            'name'               => 'cat_paths',
            'type'               => 'char',
            'field_type'         => 'char',
            'min'                => 0,
            'max'                => 255,
            'label'              => '关系路径',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_level' => [
            'name'               => 'cat_level',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => -128,
            'max'                => 127,
            'label'              => '层次级别',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_type' => [
            'name'               => 'cat_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '分类类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'cat_status' => [
            'name'               => 'cat_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '状态',
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
        'key' => 'cat_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'cat_id'      => 0,
        'cat_name'    => '',
        'cat_parent'  => 0,
        'cat_sort'    => 0,
        'cat_user_id' => 0,
        'cat_paths'   => '#0#',
        'cat_level'   => 0,
        'cat_type'    => 0,
        'cat_status'  => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'cat_id'      => ['re\rgx\filter', 'int'],
        'cat_name'    => ['re\rgx\filter', 'char'],
        'cat_parent'  => ['re\rgx\filter', 'int'],
        'cat_sort'    => ['re\rgx\filter', 'int'],
        'cat_user_id' => ['re\rgx\filter', 'int'],
        'cat_paths'   => ['re\rgx\filter', 'char'],
        'cat_level'   => ['re\rgx\filter', 'int'],
        'cat_type'    => ['re\rgx\filter', 'int'],
        'cat_status'  => ['re\rgx\filter', 'int'],
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