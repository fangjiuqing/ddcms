<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + pre_task 表模型
  + ----------------------------------------------------------------
  + @date 2018-05-09 15:49:36
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class task_table extends table {

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
        'task_id' => [
            'name'               => 'task_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '任务编号',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_type' => [
            'name'               => 'task_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '任务类型',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_status' => [
            'name'               => 'task_status',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '任务状态',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_adate' => [
            'name'               => 'task_adate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '添加时间',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_cdate' => [
            'name'               => 'task_cdate',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '完成时间',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_desc' => [
            'name'               => 'task_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 512,
            'label'              => '任务内容',
            'allow_empty_string' => true,
            'allow_null'         => true
        ],
        'task_result' => [
            'name'               => 'task_result',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 255,
            'label'              => '处理结果',
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
        'key' => 'task_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'task_id'     => 0,
        'task_type'   => 0,
        'task_status' => 0,
        'task_adate'  => 0,
        'task_cdate'  => 0,
        'task_desc'   => '',
        'task_result' => '',
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'task_id'     => ['re\rgx\filter', 'int'],
        'task_type'   => ['re\rgx\filter', 'int'],
        'task_status' => ['re\rgx\filter', 'int'],
        'task_adate'  => ['re\rgx\filter', 'int'],
        'task_cdate'  => ['re\rgx\filter', 'int'],
        'task_desc'   => ['re\rgx\filter', 'char'],
        'task_result' => ['re\rgx\filter', 'char'],
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