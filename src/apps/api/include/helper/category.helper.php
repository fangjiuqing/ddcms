<?php
namespace re\rgx;

/**
 * 分类相关助手类
 */
class category_helper extends rgx {

    /**
     * 是否合法
     * @var [type]
     */
    public static $cat_type = [
        'CAT_MET'   => ['id' => 1, 'name' => '材料分类'],
        'CAT_PRO'   => ['id' => 2, 'name' => '产品分类'],
        'CAT_ART'   => ['id' => 3, 'name' => '文章分类'],
    ];

    /**
     * [获取并验证分类类别是否合法]
     * @param  [type] $cat_type [description]
     * @return [type]           [description]
     */
    public static function cat_type($cat_type) {
        if ( TRUE == ($item = self::$cat_type[$cat_type]) ) {
            return $item;
        }
        return [];
    }

    /**
     * 转换为树形结构
     * @param number $root_id
     * @param bool $simple
     */
    public static function to_tree ($list, $simple = false) {
        $ret = [];
        foreach ($list as $k => $v) {
            if ((int)$v['cat_level'] === 0) {
                $v['nodes'] = [];
                $ret[$v['cat_id']] = $v;
            }
            else {
                $ref = &$ret;
                $paths = explode('#', substr(substr($v['cat_paths'], 3), 0, -1));
                while (!empty($paths)) {
                    $path = array_shift($paths);
                    $ref = &$ref[$path]['nodes'];
                }
                $v['nodes'] = [];
                $ref[$v['cat_id']] = $v;
            }
        }
        if ($simple) {
            $ret = self::_to_simple($ret, $has_spec);
        }
        return $ret;
    }

    /**
     * tree to simple array
     * @param unknown $data
     */
    private static function _to_simple ($data) {
        $result = new rgx();
        $result->data = [];
        array_walk($data, function ($v, $k, $res) use ($has_spec) {
            if (count($v) > 1) {
                $res->data[] = &$v;
            }
            if (!empty($v['nodes'])) {
                $res->data = array_merge($res->data, self::_to_simple($v['nodes'], $has_spec));
                unset($v['nodes']);
            }
            else {
                $v['last'] = true;
            }
        }, $result);
        return $result->data;
    }
}//Class End
