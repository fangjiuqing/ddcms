<?php
namespace re\rgx;
/**
 * 杂项操作类
 * @author reginx
 */
class misc extends rgx {

    /**
     * 获取表达式对应的字节长度
     * @param string $val
     * @return number
     */
    public static function get_byte_len ($val) {
        $len  = floatval($val);
        switch (strtolower($val{strlen($val) - 1})) {
            case 'g': $len *= 1024;
            case 'm': $len *= 1024;
            case 'k': $len *= 1024;
        }
        return ceil($len);
    }

    /**
     * 获取随机字串
     * @param number $len
     * @return string
     */
    public static function randstr ($len = 4) {
        $ret = '';
        $randstr = '23456789abcdefghjkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVW';
        for ($i = 0; $i < $len; $i ++) {
            $ret .= $randstr[mt_rand(0, strlen($randstr) - 1)];
        }
        return $ret;
    }

    /**
     * 截取字符串 ( for template)
     * @param string $str
     * @param number $len
     * @param string $suf
     * @return string
     */
    public static function cut_str ($str, $len, $suf = '') {
        $str = trim(filter::text($str));
        return mb_substr($str, 0, $len, 'utf-8') . 
                (mb_strlen($str, 'utf-8') > $len ? $suf : '');
    }

    /**
     * 创建文件夹
     * @param string $dir
     * @param boolean $index_file
     * @throws exception
     */
    public static function mkdir ($dir, $index_file = true) {
        if (!is_dir($dir)) {
            if (mkdir($dir, 0755, true)) {
                $index_file && file_put_contents($dir . '/index.html', '', LOCK_EX);
            }
            else {
                throw new exception(LANG('failed to create dir', 
                    misc::relpath($dir)), exception::IO_ERROR);
            }
        }
    }

    /**
     * 递归删除目录及文件 (仅限 data 或 /dev/shm 目录下)
     * @param string $dir
     * @return number
     */
    public static function rmrf ($dir) {
        $nums = 0;
        if (is_dir($dir)) {
            $dir = realpath($dir) . DS;
            $exec_rm = false;
            // 清理 /dev/shm 目录内容
            if (preg_match('#^' . preg_quote('/dev/shm') . '#iu', $dir) 
                && strpos($dir, '..') === false) {
                $exec_rm = true;
            }
            // data 目录下
            else if (preg_match('#^' . preg_quote(DATA_PATH) . '#iu', $dir) 
                && strpos($dir, '..') === false) {
                $exec_rm = true;
            }
            else {
                throw new Exception(LANG('failed to remove dir', misc::relpath($dir)), exception::IO_ERROR);
            }
            if ($exec_rm) {
                foreach (glob($dir .'*') as $v) {
                    if (is_dir($v)) {
                        $nums += self::rmrf($v);
                    }
                    else {
                        unlink($v);
                        $nums ++;
                    }
                }
                rmdir($dir);
            }
        }
        return $nums;
    }

    /**
     * 获取相对路径 (仅供错误输出用)
     * @param string $path
     * @return mixed
     */
    public static function relpath ($path) {
        return str_replace([INC_PATH, APP_PATH, RGX_PATH], 
                    ['INC:', 'APP:', 'RGX:'], $path);
    }

    /**
     * 获取执行内存使用情况 (unit M)
     * @return number[]
     */
    public static function get_memory_usage () {
        return [
            'current'   => memory_get_usage(true) / 1048576,
            'peak'      => memory_get_peak_usage(true) / 1048576
        ];
    }

    /**
     * 获取状态信息
     * @return number[]
     */
    public static function get_profile () {
        return [
            'db'        => app::db()->get_profile(),
            'memory'    => self::get_memory_usage()
        ];
    }

    /**
     * 获取百分比
     * @param number $a
     * @param number $b
     * @param string $suf
     * @return string
     */
    public static function pencent ($a, $b, $suf = ' %') {
        return $b > 0 ? 
                (round($a / $b , 4) * 100 . $suf ) : ('0' . $suf);
    }
}