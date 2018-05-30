<?php
namespace re\rgx;

/**
 * 商品属性接口
 */
class store_goods_attr_iface extends ubase_iface {

    /**
     * 获取属性列表
     * @return [type] [description]
     */
    public function list_action () {
        $this->success('', [
            'type'  => OBJ('goods_type_table')->get([
                'gt_id' => (int)$this->data['type']
            ]),
            'list'  => OBJ('goods_attr_table')->order('ga_id desc')->get_all([
                'ga_type_id'    => (int)$this->data['type']
            ])
        ]);
    }

    /**
     * 获取属性详情
     * @return [type] [description]
     */
    public function get_action () {
        $this->success('', [
            'row'       => OBJ('goods_attr_table')->get((int)$this->data['id']) ?: null,
            'input'     => store_helper::$attr_input_type,
            'filter'    => store_helper::$attr_filter,
        ]);
    }

    /**
     * 属性保存
     * @return [type] [description]
     */
    public function save_action () {
        $this->verify([
            'ga_name' => [
                'code' => '101',
                'msg'  => '请输入属性名称',
                'rule' => filter::$rules['require']
            ],
            'ga_type_id' => [
                'code' => '101',
                'msg'  => '未指定的商品类型',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_int']
            ],
            'ga_is_filter' => [
                'code' => '101',
                'msg'  => '请选择是否为筛选项',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_int']
            ],
            'ga_input_type' => [
                'code' => '101',
                'msg'  => '请选择输入方式',
                'rule' => ['\\re\\rgx\\filter', 'is_positive_int']
            ],
        ]);
        $tab = OBJ('goods_attr_table');
        if ($tab->load($this->data)) {
            $ret = $tab->save();
            if ($ret['code'] === 0) {
                $this->success('操作成功');
            }
        }
        $this->failure($tab->get_error_desc());
    }
}
