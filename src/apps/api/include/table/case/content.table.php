<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 资讯内容 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-03 20:12:28
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api --name=case_content
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class case_content_table extends table {

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
        'case_content' => [
            'name'               => 'case_content',
            'type'               => 'char',
            'field_type'         => 'mediumtext',
            'min'                => 0,
            'max'                => 16777215,
            'label'              => '案例内容',
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
        'inc' => false
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'case_id'     => 0,
        'case_content'=> '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'case_id'     => ['re\rgx\filter', 'int'],
        'case_content'=> ['re\rgx\filter', 'char'],
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