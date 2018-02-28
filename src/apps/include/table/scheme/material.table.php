<?php
namespace re\rgx;

/*
  +-----------------------------------------------------------------
  + 方案材料 表模型
  + ----------------------------------------------------------------
  + @date 2018-02-28 16:35:24
  + @desc 若修改了表结构, 请使用下面的命令更新模型文件
  + @cmd  php rgx/build.php --prefix=./apps/admin
  + @generator RGX v1.0.0.20171212_RC
  +-----------------------------------------------------------------
*/
class scheme_material_table extends table {

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
        'psm_id' => [
            'name'               => 'psm_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '材料编号',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_sch_id' => [
            'name'               => 'psm_sch_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属方案',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_mat_id' => [
            'name'               => 'psm_mat_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '材料ID',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_mat_name' => [
            'name'               => 'psm_mat_name',
            'type'               => 'char',
            'field_type'         => 'varchar',
            'min'                => 0,
            'max'                => 64,
            'label'              => '材料名称',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_price' => [
            'name'               => 'psm_price',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 10,
            'max'                => 2,
            'label'              => '材料单价',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_amount' => [
            'name'               => 'psm_amount',
            'type'               => 'int',
            'field_type'         => 'smallint',
            'min'                => 0,
            'max'                => 65535,
            'label'              => '材料总数',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_type' => [
            'name'               => 'psm_type',
            'type'               => 'int',
            'field_type'         => 'tinyint',
            'min'                => 0,
            'max'                => 255,
            'label'              => '材料类型',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_total' => [
            'name'               => 'psm_total',
            'type'               => 'float',
            'field_type'         => 'decimal',
            'min'                => 12,
            'max'                => 2,
            'label'              => '合计价格',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_cus_id' => [
            'name'               => 'psm_cus_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客户',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_cs_id' => [
            'name'               => 'psm_cs_id',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '所属客服',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_atime' => [
            'name'               => 'psm_atime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '发布时间',
            'allow_empty_string' => false,
            'allow_null'         => false
        ],
        'psm_utime' => [
            'name'               => 'psm_utime',
            'type'               => 'int',
            'field_type'         => 'int',
            'min'                => 0,
            'max'                => 4294967295,
            'label'              => '更新时间',
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
        'key' => 'psm_id',
        'inc' => true
    ];

    /*
      +--------------------------
      + 字段默认值
      +--------------------------
    */
    public $defaults = [
        'psm_id'      => 0,
        'psm_sch_id'  => 0,
        'psm_mat_id'  => 0,
        'psm_mat_name'=> '',
        'psm_price'   => 0.00,
        'psm_amount'  => 0,
        'psm_type'    => 0,
        'psm_total'   => 0.00,
        'psm_cus_id'  => 0,
        'psm_cs_id'   => 0,
        'psm_atime'   => 0,
        'psm_utime'   => 0,
    ];

    /*
      +--------------------------
      + 字段过滤规则
      +--------------------------
    */
    public $filter = [
        'psm_id'      => ['re\rgx\filter', 'int'],
        'psm_sch_id'  => ['re\rgx\filter', 'int'],
        'psm_mat_id'  => ['re\rgx\filter', 'int'],
        'psm_mat_name'=> ['re\rgx\filter', 'char'],
        'psm_price'   => ['re\rgx\filter', 'float'],
        'psm_amount'  => ['re\rgx\filter', 'int'],
        'psm_type'    => ['re\rgx\filter', 'int'],
        'psm_total'   => ['re\rgx\filter', 'float'],
        'psm_cus_id'  => ['re\rgx\filter', 'int'],
        'psm_cs_id'   => ['re\rgx\filter', 'int'],
        'psm_atime'   => ['re\rgx\filter', 'int'],
        'psm_utime'   => ['re\rgx\filter', 'int'],
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