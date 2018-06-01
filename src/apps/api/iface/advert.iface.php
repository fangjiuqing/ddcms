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
            $ad_ret['ad_desc']      = filter::json_unecsape($ad_ret['ad_desc']);
            if (is_array($ad_ret['ad_desc'])) {
                $ad_ret['ad_url']       = $ad_ret['ad_desc']['ad_url'];
                $ad_ret['ad_image']     = IMAGE_URL . $ad_ret['ad_desc']['ad_image'] . '!500x309';
            }
            unset($ad_ret['ad_desc']);
            $out['row']             = $ad_ret;
        }
        $out['ad_status'] = ad_helper::$ad_status;
        $this->success('操作成功', $out);
    }
    
    /**
     * 广告列表
     */
    public function list_action () {
        $ad_tab = OBJ('ad_table');
        $paging = new paging_helper($ad_tab, $this->data['pn'] ?: 1, 12);
        $ad_ret = $ad_tab->map(function ($row) {
            $row['ad_status']   = ad_helper::$ad_status[$row['ad_status']];
            $row['ad_desc']     = filter::json_unecsape($row['ad_desc']);
            return $row;
        })->order('ad_adate desc')->get_all();
        $arr = [];
        foreach ((array)$ad_ret as $k => $v) {
            $arr[$k]['ad_id']   = $v['ad_id'];
            $arr[$k]['ad_name'] = $v['ad_name'];
            $arr[$k]['ad_status']       = $v['ad_status'];
            if (is_array($v['ad_desc'])) {
                $arr[$k]['ad_url']      = $v['ad_desc']['ad_url'];
                $arr[$k]['ad_image']    = IMAGE_URL . $v['ad_desc']['ad_image'] . '!500x309';
            }
            $arr[$k]['ad_adate']    = $v['ad_adate'];
        }
        $this->success('操作成功', [
            'list'      => array_values($arr),
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
        $this->data['ad_id']        = filter::int($this->data['ad_id']);
        $this->data['ad_name']      = filter::text($this->data['ad_name']);
        $this->data['ad_status']    = filter::int($this->data['ad_status']) ?: 0;
        $this->data['ad_adate']     = filter::int($this->data['ad_adate']) ?: REQUEST_TIME;
        $this->data['ad_desc']      = filter::json_ecsape([
            'ad_url'   => $this->data['ad_url'],
            'ad_image' => $this->data['ad_image'],
        ]);
        if ($ad_tab->load($this->data)) {
            $ad_ret = $ad_tab->save();
            if ($ad_ret['code'] === 0) {
                admin_helper::add_log($this->login['admin_id'], 'advert/save', '2', ($this->data['ad_id'] ?
                    '广告修改[' . $this->data['ad_id'] : '广告新增[' . $ad_ret['row_id']) . '@' . $this->data['ad_name'] . ']');
                $this->success('操作成功');
            }
        }
        $this->failure($ad_tab->get_error_desc());
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