<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 案例表 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-03 16:01:34
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class case_table extends table {

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
        'case_id' => [
            'name'               => 'case_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '案例编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_title' => [
            'name'               => 'case_title',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '案例标题',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_cat_id' => [
            'name'               => 'case_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属分类',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_style_id' => [
            'name'               => 'case_style_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '主风格ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_style_tags' => [
            'name'               => 'case_style_tags',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '风格标签',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_space_id' => [
            'name'               => 'case_space_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '空间类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_type_id' => [
            'name'               => 'case_type_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '户型ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_layout_id' => [
            'name'               => 'case_layout_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '布局ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_layout_tags' => [
            'name'               => 'case_layout_tags',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '布局标签',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_admin_id' => [
            'name'               => 'case_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '录入人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_admin_nick' => [
            'name'               => 'case_admin_nick',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '录入人姓名',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_cover' => [
            'name'               => 'case_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '封面图片',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_image_count' => [
            'name'               => 'case_image_count',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '图片数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_adate' => [
            'name'               => 'case_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_udate' => [
            'name'               => 'case_udate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '更新时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'case_designer_id' => [
            'name'               => 'case_designer_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属设计师',
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
        'key' => 'case_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'case_id'         => 0,
        'case_title'      => '',
        'case_cat_id'     => 0,
        'case_style_id'   => 0,
        'case_style_tags' => '',
        'case_space_id'   => 0,
        'case_type_id'    => 0,
        'case_layout_id'  => 0,
        'case_layout_tags'=> '',
        'case_admin_id'   => 0,
        'case_admin_nick' => '',
        'case_cover'      => '',
        'case_image_count'=> 0,
        'case_adate'      => 0,
        'case_udate'      => 0,
        'case_designer_id'=> 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'case_id'         => ['re\rgx\filter', 'int'],
        'case_title'      => ['re\rgx\filter', 'char'],
        'case_cat_id'     => ['re\rgx\filter', 'int'],
        'case_style_id'   => ['re\rgx\filter', 'int'],
        'case_style_tags' => ['re\rgx\filter', 'char'],
        'case_space_id'   => ['re\rgx\filter', 'int'],
        'case_type_id'    => ['re\rgx\filter', 'int'],
        'case_layout_id'  => ['re\rgx\filter', 'int'],
        'case_layout_tags'=> ['re\rgx\filter', 'char'],
        'case_admin_id'   => ['re\rgx\filter', 'int'],
        'case_admin_nick' => ['re\rgx\filter', 'char'],
        'case_cover'      => ['re\rgx\filter', 'char'],
        'case_image_count'=> ['re\rgx\filter', 'int'],
        'case_adate'      => ['re\rgx\filter', 'int'],
        'case_udate'      => ['re\rgx\filter', 'int'],
        'case_designer_id'=> ['re\rgx\filter', 'int'],
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