<?php
namespace re\rgx;

/**
 * 统计助手类
 */
class stat_helper extends rgx {

    /**
     * 统计数据类型
     * @var [type]
     */
    public static $type = [
        1       => '资讯',
        2       => '案例',
        3       => '设计师'
    ];

    /**
     * 资讯类型
     */
    const TYPE_ARTICLE          = 1;

    /**
     * 案例类型
     */
    const TYPE_CASE             = 2;

    /**
     * 设计师类型
     */
    const TYPE_DESIGNER         = 3;

    /**
     * 访问来源
     * @var [type]
     */
    public static $via = [
        1       => 'PC',
        2       => 'WAP'
    ];

    /**
     * 来源 pc
     */
    const VIA_PC                = 1;

    /**
     * 来源 wap
     */
    const VIA_WAP               = 2;
    
    /**
     * @param int $type 内容类型
     * @param int $id 内容id
     * @param int $via 访问来源
     * @param int $user_id 用户id
     * @return bool
     * author Fox
     */
    public static function count ($type, $id, $via, $user_id = 0) {
        $tab = OBJ('stat_table');
        $hash = md5($id . $type . $via . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . date('Y-m-d', time()));
        if ($tab->get([
            'stat_hash' => $hash,
        ])) {
            return true;
        }
        if ($tab->load([
            'stat_type'     => (int)$type,
            'stat_ref_id'   => (int)$id,
            'stat_year'     => (int)date('Y', time()),
            'stat_month'    => (int)date('m', time()),
            'stat_day'      => (int)date('d', time()),
            'stat_adate'    => REQUEST_TIME,
            'stat_via'      => (int)$via,
            'stat_user_id'  => $user_id,
            'stat_hash'     => $hash,
        ])) {
            return $tab->insert()['code'] === 0;
        }
    }
    
}
