<?php
namespace re\rgx;

/**
 * 上传助手类
 */
class upload_helper extends rgx {

    /**
     * 允许的类型
     *
     * @var unknown_type
     */
    private $_allows = '';

    /**
     * 最大文件尺寸
     *
     * @var unknown_type
     */
    private $_maxsize = 0;

    /**
     * 保存目录
     *
     * @var unknown_type
     */
    private $_savedir = '';

    /**
     * 上传文件信息
     * @var unknown
     */
    private $_files = [];

    /**
     * 可上传的 MIME 列表
     * @var [type]
     */
    public static $mimes = [
        1   => 'application/octet-stream',
        2   => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        3   => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        4   => 'text/plain',
        5   => 'application/x-rar',
        6   => 'application/zip',
        7   => 'video/mp4',
        8   => 'image/jpeg',
        9   => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        10  => 'application/x-gzip',
        12  => 'image/png',
        14  => 'image/gif',
        15  => 'application/pdf',
        16  => 'application/msword',
        17  => 'application/vnd.ms-office',
        18  => 'application/vnd.ms-excel'
    ];

    public static function check_mime_type ($file) {
        $ret  = false;
        $mime = mime_content_type($file);
        if (in_array($mime, self::$mimes)) {
            if (!in_array(strtolower(pathinfo($file)['extension']), [
                    'php', 'sh', 'bash', 'exe', 'bat'
                ])) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * 验证文件是否为可用的上传文件
     *
     * @param unknown_type $file
     * @return unknown
     */
    public static function is_upload_file ($file) {
        if (preg_match('/^[0-9a-zA-Z\-\_\/]+\.[0-9a-zA-Z]+(\.[0-9a-zA-Z]+)*$/', $file) && file_exists(UPLOAD_PATH . $file)) {
            return true;
        }
        return false;
    }

    /**
     * 获取文件保存名称
     *
     * @param unknown_type $ext
     * @return unknown
     */
    public function get_save_name ($ext = 'unkown', $pre = 'pre_') {
        return $pre . strtolower(misc::randstr(12) . "." . $ext);
    }

    /**
     * 获取上传目录
     *
     * @param unknown_type $date
     * @return unknown
     */
    public function get_dir ($date = null) {
        static $curdir = null;
        if ($curdir === null) {
            $curdir = date('Y-m-d', $date ? $date : REQUEST_TIME) . '/';
        }
        return $curdir;
    }

    /**
     * 获取文件扩展名
     *
     * @param unknown_type $file
     * @return unknown
     */
    public function getfileext ($file) {
        $ret = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        return $ret == 'jpeg' ? 'jpg' : $ret;
    }

    /**
     * 架构函数
     *
     * @return upload_lib
     */
    public function __construct ($allows = 'JPG|GIF|JPEG|PNG|RAR|ZIP|GZ|TAR', $maxsize = '8M', $sdir = null) {
        $this->_allows = strtolower($allows);
        $this->_maxsize = $this->get_limit_size($maxsize);
        if ($sdir === null) {
            $this->_savedir = $this->get_dir();
            // auto create dir
            if (!is_dir(UPLOAD_PATH . $this->_savedir)) {
                if (mkdir(UPLOAD_PATH . $this->_savedir, 0755)) {
                    file_put_contents(UPLOAD_PATH . $this->_savedir . 'index.html', ' ');
                }
                else {
                    throw new exception(LANG('directory not available', $this->_savedir), exception::NOT_EXISTS, true);
                }
            }
        }
        else {
            $this->_savedir = $sdir;
            if (!is_dir(UPLOAD_PATH . $this->_savedir)) {
                misc::mkdir(UPLOAD_PATH . $this->_savedir);
            }
        }
        $this->_format($_FILES);
    }

    /**
     * 格式化
     * @param unknown $files
     */
    public function _format ($files) {
        foreach ((array)$files as $k => $v) {
            $this->_files[$k] = [];
            if (is_array($v['name'])) {
                // name type ...
                foreach ($v as $skey => $file) {
                    foreach ($file as $index => $item) {
                        if (!isset($this->_files[$k][$index])) {
                            $this->_files[$k][$index] = [];
                        }
                        $this->_files[$k][$index][$skey] = $item;
                    }
                }
            }
            else {
                $this->_files[$k] = $v;
            }
        }
    }

    /**
     * 获取文件
     *
     * @param unknown_type $key
     * @param unknown_type $savename
     * @param unknown_type $quiet
     * @return unknown
     */
    public function get ($key = null, $savename = null, $quiet = false) {
        $ret = [
            'code' => 0,
            'msg' => ''
        ];
        // empty
        if (empty($this->_files)) {
            $ret['code'] = 1;
            $ret['msg']  = LANG('not exists');
        }
        // key does't exists
        else if ($key != null && !isset($this->_files[$key])) {
            $ret['code'] = 1;
            $ret['msg']  = LANG('not exists', $key);
        }
        // fetch all
        else if ($key === null) {
            $ret = array();
            foreach ($this->_files as $k => $v) {
                $tmp_savename = $savename;
                if (is_array($savename)) {
                    $tmp_savename = isset($savename[$k]) ? $savename[$k] : null;
                }
                $ret[$k] = $this->_get($this->_files[$k][0] ?: $this->_files[$k], $tmp_savename, $quiet);
            }
        }
        // fetch one
        else {
            $ret = $this->_get($this->_files[$key][0] ?: $this->_files[$key], $savename, $quiet);
        }
        return count($ret) == 1 ? array_shift($ret) : $ret;
    }

    /**
     * 获取文件
     *
     * @param unknown_type $file
     * @return unknown
     */
    private function _get ($file, $savename = null, $quiet = false) {
        $file['code'] = 1;
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        $file['isimage'] = in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
        if ($file['isimage']) {
            $info = image::get_instance()->get_info($file['tmp_name']);
            $file['ext']  = $info['ext'];
            $file['width']   = $info['width'];
            $file['height']  = $info['height'];
            $file['mime']    = $info['mime'];
        }
        else {
            $file['ext']  = $this->getfileext($file);
        }
        $file['error'] = $this->_check($file);
        if (empty($file['error'])) {
            if ($savename === null) {
                $file['savedir']  = $this->_savedir;
                $file['savename'] = $this->get_save_name($file['ext']);
            }
            else {
                list($file['savedir'], $file['savename']) = explode('/', $savename, 2);
                $file['savedir'] .= '/';
                if (!is_dir(UPLOAD_PATH . dirname($savename))) {
                    misc::mkdir(UPLOAD_PATH . dirname($savename));
                }
            }
            if (move_uploaded_file($file['tmp_name'], UPLOAD_PATH . $file['savedir'] . $file['savename'])) {
                $file['code'] = 0;

                # extra处理
                $extra = $_POST['extra'];
                switch ($extra) {
                    # 发票识别
                    case 'receipt':
                        $file['receipt'] = ocr_helper::receipt(UPLOAD_PATH . $file['savedir'] . $file['savename']);
                        break;

                    default:
                        # code...
                        break;
                }

            }
            else if (!$quiet) {
                throw new exception(LANG('failed to move file', $file['tmp_name'],
                        UPLOAD_PATH . $file['savedir'] . $file['savename']), 'upload', 1);
            }
            else {
                $file['error'] = LANG('failed to move file', $file['tmp_name'],
                        UPLOAD_PATH . $file['savedir'] . $file['savename']);
            }
        }
        unset($file['tmp_name'], $file['type']);
        return $file;
    }

    /**
     * 检测文件是否符合条件
     *
     * @param unknown_type $file
     * @return unknown
     */
    private function _check ($file) {
        $error = '';
        // 已正确上传检查
        if ((int)$file['error'] === 0) {
            // 是否通过http post 上传
            if (!is_uploaded_file($file['tmp_name'])) {
                $error = LANG('Invalid upload files');
            }
            // 文件大小
            else if ($file['size'] > $this->_maxsize) {
                $error = LANG('file size exceeds the system limit', $file['name'], intval($file["size"]/1024),
                        intval(($this->_maxsize) / 1024));
            }
            // 文件类型
            else if (strrpos(strtolower($this->_allows), strtolower($file['ext'])) === false) {
                $error = LANG('file type is not allowed', $file['ext']);
            }
        }
        // 文件过大
        else if ($file['error'] <= 2) {
            $error = LANG('file size exceeds the system limit', $file['name'], intval($file["size"]/1024),
                    intval(($this->_maxsize) / 1024));
        }
        // 上传不完整, 部分内容丢失
        else if ($file['error'] == 3) {
            $error = LANG('part of the file is missing');
        }
        // 没有文件
        else if ($file['error'] == 4) {
            $error = LANG('please select a file to upload');
        }
        // 临时文件不存在
        else if ($file['error'] == 6) {
            $error = LANG('directory does not exist', 'upload temp dir');
        }
        // 文件写入失败
        else if ($file['error'] == 7) {
            $error = LANG('failed to write file');
        }
        return $error;
    }


    /**
     * 获取服务器支持的最大文件大小
     *
     * @param unknown_type $k
     * @return unknown
     */
    public function get_limit_size ($size) {
        $max = min(
            misc::get_byte_len(ini_get('memory_limit')),
            misc::get_byte_len(ini_get('post_max_size')),
            misc::get_byte_len(ini_get('upload_max_filesize'))
        );
        if ((int)$max === 0) {
            $max = misc::get_byte_len($size);
        }
        return $max;
    }
}