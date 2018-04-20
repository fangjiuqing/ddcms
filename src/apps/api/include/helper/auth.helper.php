<?php
namespace re\rgx;

/**
 * 权限检测助手
 */
class auth_helper extends rgx {

    /**
     * 检测规则
     * @var [type]
     */
    public static $rules = [
        '*_iface::get_action@before'    => ['\\re\\rgx\\auth_helper', 'check'],
        '*_iface::save_action@before'   => ['\\re\\rgx\\auth_helper', 'check'],
        '*_iface::del_action@before'    => ['\\re\\rgx\\auth_helper', 'check'],
        '*_iface::list_action@before'   => ['\\re\\rgx\\auth_helper', 'check']
    ];

    /**
     * 检测 Get 操作
     * @param  array  $moment [description]
     * @return [type]         [description]
     */
    public static function check ($moment = []) {
        if (!empty($moment['ref']->login['allows']) 
            && !isset($moment['ref']->login['allows'][$moment['code']])) {
            $moment['ref']->failure('您无权进行该操作', 9999);
        }
    }
}
