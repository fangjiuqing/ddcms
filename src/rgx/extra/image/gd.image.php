<?php
namespace re\rgx;
/**
 * GD图像处理类
 * @author reginx
 */
class gd_image extends image {

    /**
     * 支付的格式
     * @var array
     */
    public static $ext = ['jpg' , 'jpeg' , 'gif' , 'png' , 'bmp'];

    /**
     *  生成缩略图相关属性(剪切方式)
     * @param number $srcw
     * @param number $srch
     * @param number $dstw
     * @param number $dsth
     * @return mixed
     */
    private static function get_cut_prop ($srcw, $srch, $dstw, $dsth) {
        $prop            = max($dstw / $srcw, $dsth / $srch);
        $ret['width']    = min($srcw, $dstw);
        $ret['height']   = min($srch, $dsth);
        $ret['t_width']  = min(floor($prop * $srcw), $srcw);
        $ret['t_height'] = min(floor($prop * $srch), $srch);
        $ret['left']     = sprintf("%.2f", ($ret['t_width']  - $ret['width'] ) / 2);
        $ret['top']      = sprintf("%.2f", ($ret['t_height'] - $ret['height']) / 2);
        return $ret;
    }


    /**
     * 生成验证码
     * {@inheritDoc}
     * @see \re\rgx\image::captcha()
     */
    public function captcha ($str, $config = []) {
        $width  = $config['width'];
        $height = $config['height'];
        $border = $config['border'];
        $font   = $config['font'];
        $width  = intval($width)  ? intval($width)  : (strlen($str) * 10 + 10);
        $height = intval($height) ? intval($height) : 20;

        $img = imagecreatetruecolor($width, $height);
        // 背景颜色.
        $bgcolor     = imagecolorallocate($img , 253 , 253 , 253);
        // 边框颜色
        $bordercolor = imagecolorallocate($img , 99 , 99 , 99);
        // 文字颜色
        $fontcolor   = imagecolorallocate($img , mt_rand(0, 50), mt_rand(0, 30), mt_rand(0, 80));
        // 填充背景色
        imagefilledrectangle($img, 0, 0, $width, $height, $bgcolor);

        // 设置边框颜色
        if ($border) {
            imagerectangle($img, 0, 0, $width - 1 , $height - 1 , $bordercolor);
        }
        // 干扰线
        for ($i = 0; $i < 5; $i++) {
            $color = imagecolorallocate($img, mt_rand(180, 250), mt_rand(150, 250), mt_rand(180, 250));
            imageline($img, mt_rand(1, $width - 2), mt_rand(1, $height - 2), mt_rand($width / 3, $width - 1),
                mt_rand($height / 3, $height - 1), $color);
        }
        // 干扰点
        for ($i = 0; $i < 50; $i++) {
            $color = imagecolorallocate($img, mt_rand(120, 255), mt_rand(120, 255), mt_rand(120, 255));
            imagesetpixel($img, mt_rand(2, $width - 2), mt_rand(2, $height - 2), $color);
        }
        if ($font && is_file($font)) {
            $fontcolor = imagecolorallocate($img, mt_rand(0, 80), mt_rand(0, 80), mt_rand(0, 80));
            imagettftext($img, 25, mt_rand(-2, 2), 5, mt_rand(20, 25), $fontcolor, $font, $str);
        }
        else {
            // 写入文字
            imagestring($img, 5, $width / (strlen($str) + 2), $height / 7, strtoupper($str), $fontcolor);
        }
        // 输出
        header("Cache-Control: max-age=s-maxage=no-cache, must-revalidate");
        header("Content-type: image/png;");
        imagepng($img);
        imagedestroy($img);
    }

    /**
     * {@inheritDoc}
     * @see \re\rgx\image::cut()
     */
    public function cut ($sfile, $dfile, $config = []) {
        // TODO 自动生成的方法存根

    }

    /**
     * 获取图像信息
     * {@inheritDoc}
     * @see \re\rgx\image::get_info()
     */
    public function get_info ($sfile) {
        if (!file_exists($sfile)) {
            throw new exception(LANG('not exists', misc::relpath($sfile)), exception::NOT_EXISTS);
        }
        $sfile = realpath($sfile);
        $info  = getimagesize($sfile);
        if ($info !== false) {
            $ext  = strtolower(substr($info['mime'], strpos($info['mime'], '/') + 1, strlen($info['mime'])));
            $ext  = $ext == 'jpeg' ? 'jpg' : $ext;
            $ext  = $ext == 'x-ms-bmp' ? 'bmp' : $ext;
            if (!in_array($ext , self::$ext)) {
                throw new exception(LANG('does not support', $ext . ' : ' . misc::relpath($sfile)), exception::NOT_SUPPORT, true);
            }
            $info = [
                'width'     => $info[0],
                'height'    => $info[1],
                'dir'       => realpath(dirname($sfile)),
                'basedir'   => basename(dirname($sfile)),
                'name'      => basename($sfile , '.' . $ext),
                'ext'       => $ext,
                'size'      => filesize($sfile),
                'mime'      => $info['mime']
            ];
        }
        return $info ?: [];
    }

    /**
     * 生成缩略图
     * {@inheritDoc}
     * @see \re\rgx\image::thumb()
     */
    public function thumb ($sfile , $outfile = 'auto' , $param = []) {
        $config            = [];
        $config['type']    = isset($param['type'])   ?: 1;
        $config['width']   = isset($param['width'])  ?: 'auto';
        $config['height']  = isset($param['height']) ?: 'auto';
        $config['quality'] = isset($param['quality'])  ?: 95;

        // 获取图片信息
        $info = $this->get_info($sfile);
        if (empty($info)) {
        	return false;
        }
        if ($info['ext'] == 'png') {
            $config['quality'] = 9;
        }
        // 读取原图片
        $simage = null;
        $func   = "imagecreatefrom" . ($info['ext'] == 'jpg' ? 'jpeg' : $info['ext']);
        if (function_exists($func)) {
            $simage = call_user_func($func, $sfile);
        }
        else {
            throw new exception(LANG('does not support' , $func), exception::NOT_SUPPORT, true);
        }
        // 构建缩略图文件名称
        if (strtolower($outfile) == 'auto') {
            $outfile  = $info['dir'] . DS . $info['name'] . '_thumb.' . $info['ext'];
        }
        if (preg_match('/^(auto|(\d{2,}))[x\_\-](auto|(\d{2,}))$/i' , $outfile)) {
            $outfile = $info['dir'] . DS . $info['name'] . '.' . $outfile .'.' . $info['ext'];
        }
        // 缩略图生成尺寸位置参数
        $pix = array();
        if ((int)$config['type'] === 1 && $config['height'] != 'auto' && $config['width'] != 'auto') {
            $pix = self::get_cut_prop($info['width'], $info['height'], $config['width'], $config['height']);
        }
        else {
            $pix = parent::get_thumb_size($info['width'], $info['height'], $config['width'], $config['height']);
        }
        // 创建缩略图
        $thumbimage = false;
        if ($info['ext'] != 'gif' && function_exists('imagecreatetruecolor')) {
            $thumbimage = imagecreatetruecolor($pix['width'], $pix['height']);
        }
        else {
            $thumbimage = imagecreate($pix['width'], $pix['height']);
        }
        $func = 'image' . ($info['ext'] == 'jpg' ? 'jpeg' : $info['ext']);
        // 处理 png , gif 背景透明问题
        if ($info['ext'] == 'png' || $info['ext'] == 'gif') {
            imagesavealpha($thumbimage, true);
            imagealphablending($thumbimage, false);
            imagesavealpha($thumbimage, true);
        }
        else {
            // 背景填充 FDFDFD
            imagecolorallocate($thumbimage, 0xFD , 0xFD , 0xFD);
        }
        // 创建临时缩略图
        $tmpimage = imagecreatetruecolor(isset($pix['t_width']) ? $pix['t_width'] : $pix['width'],
                isset($pix['t_height']) ? $pix['t_height'] : $pix['height']);
        if ($info['ext'] == 'png' || $info['ext'] == 'gif') {
            imagesavealpha($tmpimage, true);
            imagealphablending($tmpimage, false);
        }
        if (function_exists("imagecopyresampled")) {
            imagecopyresampled($tmpimage, $simage, 0, 0, 0, 0, isset($pix['t_width']) ? $pix['t_width'] : $pix['width'],
                    isset($pix['t_height']) ? $pix['t_height'] : $pix['height'], $info['width'], $info['height']);
        }
        else {
            imagecopyresized($tmpimage ,$simage ,0 ,0 ,0 , 0, isset($pix['t_width']) ? $pix['t_width'] : $pix['width'],
                    isset($pix['t_height']) ? $pix['t_height'] : $pix['height'],  $info['width'], $info['height']);
        }
        // 若为gif/png 设置颜色透明
        if ($info['ext'] == 'gif' || $info['ext'] == 'png') {
            imagecolortransparent($thumbimage, imagecolorallocate($thumbimage, 0, 255, 0));
        }
        // 对jpeg图形设置隔行扫描
        if ($info['ext'] == 'jpg' || $info['ext'] == 'jpeg') {
            imageinterlace($thumbimage, 1);
        }
        // 剪切临时缩略图部分至缩略图
        if ((int)$config['type'] == 1 && $config['height'] != 'auto' && $config['width'] != 'auto') {
            imagecopy($thumbimage, $tmpimage, 0, 0, $pix['left'], $pix['top'], $pix['width'], $pix['height']);
        }
        else {
            imagecopy($thumbimage, $tmpimage, 0, 0, 0, 0, $pix['width'], $pix['height']);
        }
        // 创建图片文件
        if ($info['ext'] == 'jpg' || $info['ext'] == 'jpeg') {
            call_user_func_array($func, [$thumbimage, $outfile, $config['quality']]);
        }
        else {
            call_user_func_array($func, [$thumbimage, $outfile, $config['quality']]);
        }
        imagedestroy($thumbimage);
        imagedestroy($tmpimage);

        return file_exists($outfile) ? ($info['basedir'] . '/' . basename($outfile)) : false;
    }

    /**
     * 生成水印
     * {@inheritDoc}
     * @see \re\rgx\image::water()
     */
    public function water ($sfile, $dfile = null, $config = []) {
        // TODO 自动生成的方法存根

    }

}