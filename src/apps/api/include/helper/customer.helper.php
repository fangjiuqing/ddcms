<?php
namespace re\rgx;

class customer_helper extends rgx {
    
    public static $verify_type = [
        1 => '手机号',
        2 => '邮箱',
        3 => '账号',
    ];
    
    const MOBILE_TYPE = 1;
    
    const EMAIL_TYPE = 2;
    
    const ACCOUNT_TYPE = 3;
    
}