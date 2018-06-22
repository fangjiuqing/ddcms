<?php
namespace re\rgx;

/**
 * 用户订单接口
 * @todo
 */
class public_store_user_order_iface extends ubase_iface {

    /**
     * 创建订单
     * @todo
     * 
        入参
             1. 配送地址
             2. 支付方式
             3. 商品 (规格) 及 数量
             4. 发票需求
     */
    public function save_action () {}

    /**
     * 获取订单列表
     * @todo
     * @return [type] [description]
     */
    public function list_action () {}


    /**
     * 设置订单 (取消)
     * @todo
     */
    public function set_action () {}


    /**
     * 删除订单
     *     1. 删除未付款 (物理删除)
     *     2. 删除已完成 (逻辑删除)
     * @todo 
     * @return [type] [description]
     */
    public function del_action () {}
}
