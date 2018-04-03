<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 案例图片表 表模型
  + ----------------------------------------------------------------
  + @date 2018-04-03 16:01:34
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/api
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class case_images_table extends table {

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
        'image_id' => [
            'name'               => 'image_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '图片ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_url' => [
            'name'               => 'image_url',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '图片地址',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_desc' => [
            'name'               => 'image_desc',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 128,
            'label'              => '图片说明',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_sort' => [
            'name'               => 'image_sort',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '图片排序',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_case_id' => [
            'name'               => 'image_case_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属案例',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_is_synced' => [
            'name'               => 'image_is_synced',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '是否已同步',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'image_is_deleted' => [
            'name'               => 'image_is_deleted',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '是否已删除',
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
        'key' => 'image_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'image_id'        => 0,
        'image_url'       => '',
        'image_desc'      => '',
        'image_sort'      => 0,
        'image_case_id'   => 0,
        'image_is_synced' => 0,
        'image_is_deleted'=> 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'image_id'        => ['re\rgx\filter', 'int'],
        'image_url'       => ['re\rgx\filter', 'char'],
        'image_desc'      => ['re\rgx\filter', 'char'],
        'image_sort'      => ['re\rgx\filter', 'int'],
        'image_case_id'   => ['re\rgx\filter', 'int'],
        'image_is_synced' => ['re\rgx\filter', 'int'],
        'image_is_deleted'=> ['re\rgx\filter', 'int'],
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