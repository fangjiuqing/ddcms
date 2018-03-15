<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 资讯 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-15 14:27:02
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class article_table extends table {

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
        'article_id' => [
            'name'               => 'article_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '日志编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_title' => [
            'name'               => 'article_title',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '资讯编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_cat_id' => [
            'name'               => 'article_cat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属分类',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_cover' => [
            'name'               => 'article_cover',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '资讯封面',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_admin_id' => [
            'name'               => 'article_admin_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '发布人',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_adate' => [
            'name'               => 'article_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '发布时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_udate' => [
            'name'               => 'article_udate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '更新时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_stat_view' => [
            'name'               => 'article_stat_view',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '累计浏览',
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
        'key' => 'article_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'article_id'          => 0,
        'article_title'       => '',
        'article_cat_id'      => 0,
        'article_cover'       => '',
        'article_admin_id'    => 0,
        'article_adate'       => 0,
        'article_udate'       => 0,
        'article_stat_view'   => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'article_id'          => ['re\rgx\filter', 'int'],
        'article_title'       => ['re\rgx\filter', 'char'],
        'article_cat_id'      => ['re\rgx\filter', 'int'],
        'article_cover'       => ['re\rgx\filter', 'char'],
        'article_admin_id'    => ['re\rgx\filter', 'int'],
        'article_adate'       => ['re\rgx\filter', 'int'],
        'article_udate'       => ['re\rgx\filter', 'int'],
        'article_stat_view'   => ['re\rgx\filter', 'int'],
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