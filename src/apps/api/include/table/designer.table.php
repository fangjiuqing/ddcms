<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_designer 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-10 11:32:44
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class designer_table extends table {

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
        'des_id' => [
            'name'               => 'des_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '设计师编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_name' => [
            'name'               => 'des_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_about' => [
            'name'               => 'des_about',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '简介',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_workyears' => [
            'name'               => 'des_workyears',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '工作年数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_style_tags' => [
            'name'               => 'des_style_tags',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '风格标签',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_concept_tags' => [
            'name'               => 'des_concept_tags',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '理念标签',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_awards' => [
            'name'               => 'des_awards',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 512,
            'label'              => '奖项',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_region0' => [
            'name'               => 'des_region0',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '省份',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_region1' => [
            'name'               => 'des_region1',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '城市',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_title' => [
            'name'               => 'des_title',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '职位',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_cover' => [
            'name'               => 'des_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 32,
            'label'              => '头像',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_slogan' => [
            'name'               => 'des_slogan',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '标语',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'des_price' => [
            'name'               => 'des_price',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 16,
            'label'              => '价格',
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
        'key' => 'des_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'des_id'          => 0,
        'des_name'        => '',
        'des_about'       => '',
        'des_workyears'   => 0,
        'des_style_tags'  => '',
        'des_concept_tags'=> '',
        'des_awards'      => '',
        'des_region0'     => 0,
        'des_region1'     => 0,
        'des_title'       => '',
        'des_cover'       => '',
        'des_slogan'      => '',
        'des_price'       => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'des_id'          => ['re\rgx\filter', 'int'],
        'des_name'        => ['re\rgx\filter', 'char'],
        'des_about'       => ['re\rgx\filter', 'char'],
        'des_workyears'   => ['re\rgx\filter', 'int'],
        'des_style_tags'  => ['re\rgx\filter', 'char'],
        'des_concept_tags'=> ['re\rgx\filter', 'char'],
        'des_awards'      => ['re\rgx\filter', 'char'],
        'des_region0'     => ['re\rgx\filter', 'int'],
        'des_region1'     => ['re\rgx\filter', 'int'],
        'des_title'       => ['re\rgx\filter', 'char'],
        'des_cover'       => ['re\rgx\filter', 'char'],
        'des_slogan'      => ['re\rgx\filter', 'char'],
        'des_price'       => ['re\rgx\filter', 'char'],
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