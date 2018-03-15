<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 资讯内容 表模型
  + ----------------------------------------------------------------
  + @date 2018-03-15 14:27:13
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class article_content_table extends table {

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
            'label'              => '资讯编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'article_content' => [
            'name'               => 'article_content',
            'type'               => 'char',
            'field_type'         => 'mediumtext',
            'min'                => 0,
            'max'                => 16777215,
            'label'              => '资讯内容',
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
        'inc' => false
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'article_id'      => 0,
        'article_content' => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'article_id'      => ['re\rgx\filter', 'int'],
        'article_content' => ['re\rgx\filter', 'char'],
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