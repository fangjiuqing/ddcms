<?php
namespace re\rgx;

/**
 * @name 用户基本操作
 */
class upload_iface extends admin_iface {

    /**
     * 获取当前登录信息
     * @return [type] [description]
     */
    public function image_action () {
        $uploader = new upload_helper('jpg');
        $file = $uploader->get('file');
        
        if ($file['error']) {
            $this->failure($file['error']);
        }

        $file['url'] = $file['savedir'] . $file['savename'];

        $out['data'] = $file;
        if ($out['data']['error']) {
            $out['code']  = 1;
            $out['error'] = $out['msg']= $out['data']['error'];
        }
        else {
            $sfile = UPLOAD_PATH . $out['data']['url'];
            // image::get_instance()->thumb($sfile, '500x309');
            // image::get_instance()->thumb($sfile, '1200xauto');
        }
        $this->success('', [
            'url'   => UPLOAD_URL . $out['data']['url'],
            'image' => $out['data']['url'],
            'thumb' => UPLOAD_URL . $out['data']['url']
        ]);
    }
}