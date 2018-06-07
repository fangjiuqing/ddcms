<?php
namespace re\rgx;

/**
 * 杂项接口模块
 */
class misc_iface extends base_iface {

    /**
     * 用户登录
     * @return [type] [description]
     */
    public function token_action () {
        $act = $this->data['action'] ?: 'common';
        $key = "pfm_token_{$act}";
        $token = $this->mod->sess_get($key);
        if (!empty($token)) {
            list($token, $date) = explode('@', $token);
            if ($date + 1800 > REQUEST_TIME) {
                // update
                $this->mod->sess_set($key, "{$token}@" . REQUEST_TIME);
                $this->success('', [
                    'token' => $token
                ]);
            }
        }
        $token = md5(REQUEST_TIME . misc::randstr(8));
        $this->mod->sess_set($key, $token . '@' . REQUEST_TIME);
        $this->success('', [
            'token' => $token
        ]);
    }


    /**
     * 获取地区列表
     * @return [type] [description]
     */
    public function region_action () {
        $id = intval($this->data['region_id']);
        $this->success('', CACHE("region@tree-{$id}", function () use ($id) {
            $ret = [];
            $tab = OBJ('region_table');
            if ($id === 0) {
                $ret = $tab->except('region_id')->akey('region_code')->get_all([
                    'region_parent' => 0
                ]);
            }
            else {
                $ret = $tab->except('region_id')->akey('region_code')->order('region_level asc')->get_all([
                    'region_code'   => function ($k) use ($id) {
                        return "{$k} like '{$id}%'";
                    }
                ]);
            }
            return $ret;
        }, -1));
    }
    
    /**
     * 地址第四级列表
     */
    public function street_action () {
        $this->success('', CACHE("region@tree-{$id}", function () use ($id) {
            return OBJ('region_tb_table')->get_all(['region_parent' => intval($this->data['region_id'])]);
        }, -1));
    }
}