<?php
namespace re\rgx;

/**
 * 商城供应商接口类
 * @author rgx
 */
class store_supplier_iface extends ubase_iface {

    /**
     * 获取查询列表
     * @return [type] [description]
     */
    public function list_action () {
        $key = filter::text($this->data['key']);
        $tab = OBJ('supplier_table')->where([
            'sup_realname'  => function ($k) use ($key) {
                return "{$k} like '{$key}%'";
            }
        ]);
        $tab->fields('sup_id,sup_realname')->order('sup_id desc')->limit(10);
        $this->success('', [
            'list'  => $tab->get_all()
        ]);
    }
}
