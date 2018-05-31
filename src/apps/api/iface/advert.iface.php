<?php
namespace re\rgx;

/**
 * Class advert_iface
 * @package re\rgx
 */
class advert_iface extends ubase_iface {
    
    /**
     * 广告详情
     * @param int $id 要获取广告的id
     */
    public function get_action () {
        $id = intval($this->data['id']);
        $ad_tab = OBJ('ad_table');
        if ($ad_ret = $ad_tab->get($id)) {
            $ad_ret['ad_status']    = ad_helper::$ad_status[$ad_ret['ad_status']];
            $ad_ret['ad_desc']      = filter::json_unecsape($ad_ret['ad_desc']);
            $ad_ret['ad_desc']['image'] = IMAGE_URL . $ad_ret['ad_desc']['image'] . '!500x309';
            $out['row']             = $ad_ret;
        }
        $out['ad_status']           = ad_helper::$ad_status;
        $this->success('操作成功', $out);
    }
    
    /**
     * 广告列表
     */
    public function list_action () {
        $ad_tab = OBJ('ad_table');
        $paging = new paging_helper($ad_tab, $this->data['pn'] ?: 1, 12);
        $ad_ret = $ad_tab->map(function ($row) {
            $row['ad_status']           = ad_helper::$ad_status[$row['ad_status']];
            $row['ad_desc']             = filter::json_unecsape($row['ad_desc']);
            $row['ad_desc']['image']    = IMAGE_URL . $row['ad_desc']['image'] . '!500x309';
            return $row;
        })->order('ad_adate desc')->get_all();
        $this->success('操作成功', [
            'list'      => array_values($ad_ret),
            'paging'    => $paging->to_array(),
        ]);
    }
    
    /**
     * 广告新增
     * @param   string  $name   广告名称
     * @param   string  $url    广告链接
     * @param   string  $image  广告图片
     */
    public function save_action () {
        $ad_tab = OBJ('ad_table');
        $arr = [];
        foreach ($this->data as $v) {
            $arr['ad_id']       = filter::int($v['id']);
            $arr['ad_name']     = filter::text($v['name']);
            $arr['ad_status']   = filter::int($v['status']) ?: 0;
            $arr['ad_desc']     = filter::json_ecsape($v);
            $arr['ad_adate']    = REQUEST_TIME;
            $ad_tab->load($arr);
            $ad_ret = $ad_tab->save();
            admin_helper::add_log($this->login['admin_id'], 'advert/save', '2', ($arr['ad_id'] ?
                    '广告修改[' . $arr['ad_id'] : '广告新增[' . $ad_ret['row_id']) . '@' . $arr['ad_name'] . ']');
        }
        $this->success('操作成功');
    }
    
    /**
     * 广告删除
     * @param int $id 要删除广告的id
     */
    public function del_action () {
        $id = intval($this->data['id']);
        $tab = OBJ('ad_table');
        if ($ad_ret = $tab->get($id)) {
            if (upload_helper::is_upload_file(json_decode($ad_ret['ad_desc'])->image)) {
                unlink(UPLOAD_PATH . json_decode($ad_ret['ad_desc'])->image);
            }
            $ret = $tab->delete(['ad_id' => $id]);
            if ($ret['rows'] === 1) {
                admin_helper::add_log($this->login['admin_id'], 'advert/del', '3', '删除广告[@' . $ad_ret['ad_name'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure('操作失败');
    }
    
}