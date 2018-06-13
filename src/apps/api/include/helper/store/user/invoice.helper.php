<?php
namespace re\rgx;

class store_user_invoice_helper extends rgx {
    
    public static $in_type  = [
        1   => '纸质普通发票',
        2   => '增值税专用发票',
    ];
    
    public static $in_status    = [
        1   => '申请中',
        2   => '已完成',
    ];
    const APPLY_STATUS  = 1;
    const DONE_STATUS   = 2;
    
    public static $in_title_type    = [
        1   => '个人',
        2   => '企业',
    ];
}
