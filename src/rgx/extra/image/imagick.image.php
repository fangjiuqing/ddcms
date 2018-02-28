<?php
namespace re\rgx;
/**
 * Imagick 图片处理库
 * @author reginx
 */
class imagick_image extends image {
    
    /**
     * 生成验证码
     * {@inheritDoc}
     * @see \re\rgx\image::captcha()
     */
    public function captcha ($str, $config = []) {
        $this->_im = new \Imagick();
        /* Create the ImagickPixel object (used to set the background color on image) */
        $bg = new \ImagickPixel();
        /* Set the pixel color to white */
        $bg->setColor($config['bgcolor'] ?: 'white');
        
        /* Create a drawing object and set the font size */
        $ImagickDraw = new \ImagickDraw();
        /* Set font and font size. You can also specify /path/to/font.ttf */
        if ($config['font']) {
            $ImagickDraw->setFont($config['font']);
        }
        $ImagickDraw->setFontSize(20);
        
        /* Create new empty image */
        $this->_im->newImage($config['width'] ?: 85, $config['height'] ?: 30, $bg);
        /* Write the text on the image */
        $this->_im->annotateImage($ImagickDraw, 4, 20, 0, $str);
        /* Add some swirl */
        $this->_im->swirlImage(20);
        
        /* Create a few random lines */
        for ($i = 0; $i <= 5; $i ++) {
            $ImagickDraw->line(mt_rand(0, 70), mt_rand(0, 30), mt_rand(0, 70), rand(0, 30));
        }
        
        /* Draw the ImagickDraw object contents to the image. */
        $this->_im->drawImage($ImagickDraw);
        
        /* Give the image a format */
        $this->_im->setImageFormat('png');
        
        /* Send headers and output the image */
        header("Cache-Control: max-age=s-maxage=no-cache, must-revalidate");
        header( "Content-Type: image/{$this->_im->getImageFormat()}" );
        exit($this->_im->getImageBlob());
    }

    /**
     * 图片裁剪
     * {@inheritDoc}
     * @see \re\rgx\image::cut()
     */
    public function cut ($sfile, $dfile, $config = array()) {
        // TODO 自动生成的方法存根
        
    }

    /**
     * 获取图片信息
     * {@inheritDoc}
     * @see \re\rgx\image::get_info()
     */
    public function get_info ($file) {
        $im = new \Imagick($file);
        $ret = [
            'ext'       => strtolower($im->getimageformat()),
            'width'     => $im->getimagewidth(),
            'height'    => $im->getimageheight(),
            'mime'      => $im->getimagemimetype()
        ];
        $ret['ext'] = $ret['ext'] == 'jpeg' ? 'jpg' : $ret['ext'];
        return $ret;
    }

    /**
     * 生成缩略图
     * {@inheritDoc}
     * @see \re\rgx\image::thumb()
     */
    public function thumb ($sfile, $dfile, $config = []) {

        if (!file_exists($sfile)) {
            throw new exception(LANG('not exists', 'image file ' . misc::relpath($sfile)), exception::NOT_EXISTS);
        }
        $this->_im = new \Imagick();
        $this->_im->readImage($sfile);
        $swidth = $this->_im->getimagewidth();
        $sheight = $this->_im->getimageheight();
        $width = $height = 0;

        if (is_array($dfile)) {
            $ret = [];
            foreach ($dfile as $v) {
                if (!preg_match('/^(\d+|auto)x(\d+|auto)$/i', $v)) {
                    throw new exception(LANG('invalid thumbnail size', $v), exception::INVALID_TYPE);
                }
                $outfile = parent::get_thumb_name($sfile, $v);
                $ret[] = $outfile;
                list($width, $height) = explode('x', strtolower($v));
                if ($width == 'auto' || $height == 'auto') {
                    list($width, $height) = parent::get_thumb_size($swidth, $sheight, $width, $height);
                }
                $this->_im->cropThumbnailImage($width, $height);
                $this->_im->writeImage($outfile);
                return $ret;
            }
        }
        else {
            if (preg_match('/^(\d+|auto)x(\d+|auto)$/i', $dfile)) {
                list($width, $height) = explode('x', strtolower($dfile));
                $dfile = parent::get_thumb_name($sfile, $dfile);
                if ($width == 'auto' || $height == 'auto') {
                    extract(parent::get_thumb_size($swidth, $sheight, $width, $height));
                }
            }
            else if ($dfile == 'auto') {
                $dfile = parent::get_thumb_name($sfile);
                $width = $swidth;
                $height = $sheight;
            }
            else {
                $config = is_array($config) ?: explode('x', $config);
                $width  = $config['width']  ?: 0;
                $height = $config['height'] ?: 0;
                if ($width == 'auto' || $height == 'auto') {
                    $size = parent::get_thumb_size($swidth, $sheight, $width, $height);
                    $width  = $size['width'];
                    $height = $size['height'];
                }
            }
            $width  = intval($width);
            $height = intval($height);

            if (min($width, $height) === 0) {
                throw new exception(LANG('invalid thumbnail size', $size), exception::INVALID_TYPE);
            }
            $this->_im->cropThumbnailImage($width, $height);
            $this->_im->writeImage($dfile);
            return $dfile;
        }
    }
    
    /**
     * 获取位置设置
     * @param number $pos
     */
    private function get_gravity ($pos) {
        switch ($pos) {
            case parent::LEFT:
                return \Imagick::GRAVITY_WEST;
            case parent::LEFT_TOP:
                return \Imagick::GRAVITY_NORTHWEST;
            case parent::LEFT_BOTTOM:
                return \Imagick::GRAVITY_SOUTHWEST;
            case parent::RIGHT:
                return \Imagick::GRAVITY_EAST;
            case parent::RIGHT_TOP:
                return \Imagick::GRAVITY_NORTHEAST;
            case parent::RIGHT_BOTTOM:
                return \Imagick::GRAVITY_SOUTHEAST;
            case parent::CENTER:
                return \Imagick::GRAVITY_CENTER;
        };
    }

    /**
     * 生成水印图
     * {@inheritDoc}
     * @see \re\rgx\image::water()
     */
    public function water ($sfile, $dfile = null, $config = []) {
        if (!file_exists($sfile)) {
            throw new exception(LANG('not exists', 'image ' + misc::relpath($sfile)), exception::NOT_EXISTS);
        }
        $dfile  = $dfile ?: $sfile;
        $simage = new \Imagick($sfile);
        $config['size']  = $config['size'] ?: 24;
        $config['color'] = $config['color'] ?: '#353535';
        $config['bgcolor'] = $config['bgcolor'] ?: 'transparent';
        $config['angle'] = $config['angle'] ?: 0;
        $config['padding'] = $config['padding'] ?: 5;
        $config['border'] = $config['border'] ? true : false;
        $config['border_color']     = $config['border_color'] ?: '#000';
        $config['border_opacity']   = $config['border_opacity'] ?: 0.6;
        $config['border_width']     = $config['border_width'] ?: 2;
        $config['position'] = $config['position'] ?: parent::CENTER;
        // 文字水印
        if (isset($config['text'])) {
            $draw = new \ImagickDraw();
            // 字体
            if (isset($config['font'])) {
                $draw->setFont($config['font']);
            }
            // 设置透明度
            if ($config['opacity'] > 0) {
                $draw->setFillOpacity($config['opacity']);
            }
            // 字号
            $draw->setFontSize($config['size']);
            // 字体颜色
            $draw->setFillColor($config['color']);
            // 背景色
            $draw->setTextUnderColor($config['bgcolor']);
            $draw->setGravity($this->get_gravity($config['position']));

            $size = [
                'swidth'    => $simage->getimagewidth(),
                'sheight'   => $simage->getimageheight(),
                'dwidth'    => strlen($config['text']) * $config['size'],
                'dheight'   => $config['size'],
                'padding'   => $config['padding'] ? intval($config['padding']) : 5
            ];
            $pos = parent::get_position($config['position'] ?: parent::CENTER, $size);

            if ($config['border']) {
                // 画背景
                $bgdraw = new \ImagickDraw();
                // 字体
                if (isset($config['font'])) {
                    $bgdraw->setFont($config['font']);
                }
                $bgdraw->setFontSize($config['size']);
                // 字体颜色
                $bgdraw->setFillColor($config['border_color']);
                $bgdraw->setFillOpacity($config['border_opacity']);
                // 背景色
                $bgdraw->setGravity($this->get_gravity($config['position']));
            }

            if ($simage->getimageformat() == 'GIF') {
                foreach($simage->coalesceImages() as $frame) {
                    if ($config['border']) {
                        $frame->annotateImage($bgdraw, $config['padding'] - $config['border_width'], 
                                $config['padding'], $config['angle'], $config['text']);
                        $frame->annotateImage($bgdraw, $config['padding'] + $config['border_width'], 
                                $config['padding'], $config['angle'], $config['text']);
                        $frame->annotateImage($bgdraw, $config['padding'], $config['padding'] - $config['border_width'], 
                                $config['angle'], $config['text']);
                        $frame->annotateImage($bgdraw, $config['padding'], $config['padding'] + $config['border_width'], 
                                $config['angle'], $config['text']);
                    }
                    $frame->annotateImage($draw, $config['padding'], $config['padding'], $config['angle'], $config['text']);
                }
            }
            else {
                if ($config['border']) {
                    $simage->annotateImage($bgdraw, $config['padding'] - $config['border_width'], 
                            $config['padding'], $config['angle'], $config['text']);
                    $simage->annotateImage($bgdraw, $config['padding'] + $config['border_width'], 
                            $config['padding'], $config['angle'], $config['text']);
                    $simage->annotateImage($bgdraw, $config['padding'], $config['padding'] - $config['border_width'], 
                            $config['angle'], $config['text']);
                    $simage->annotateImage($bgdraw, $config['padding'], $config['padding'] + $config['border_width'], 
                            $config['angle'], $config['text']);
                }
                $simage->annotateImage($draw, $config['padding'], $config['padding'], $config['angle'], $config['text']);
            }
        }
        // 图片水印
        else {
            if (!file_exists($config['image'])) {
                throw new exception(LANG('not exists', 'image ' . misc::relpath($config['image'])), exception::NOT_EXISTS);
            }
            $wimage = new \Imagick($config['image']);
            // 设置透明度
            if ($config['opacity'] > 0) {
                $wimage->setImageOpacity($config['opacity']);
            }
            $size = [
                'swidth'    => $simage->getimagewidth(),
                'sheight'   => $simage->getimageheight(),
                'dwidth'    => $wimage->getimagewidth(),
                'dheight'   => $wimage->getimageheight(),
                'padding'   => $config['padding'] ? intval($config['padding']) : 5
            ];
            $pos = parent::get_position($config['position'] ?: parent::CENTER, $size);
            
            $draw = new \ImagickDraw();
            $draw->composite($wimage->getimagecompose(), $pos['x'], $pos['y'], $size['dwidth'], $size['dheight'], $wimage);
            // GIF 处理
            if ($simage->getimageformat() == 'GIF') {
                $gif = new \Imagick();
                foreach ($simage->coalesceImages() as $frame) {
                    $img = new \Imagick();
                    $img->readImageBlob($frame);
                    $img->drawImage($draw);
                    $gif->addImage($img);
                    $gif->setImageDelay($img->getImageDelay());
                }
                $simage = $gif;
            }
            else {
                $simage->drawImage($draw);
            }
        }

        $simage->writeImage($dfile);
    }
}