<?php
namespace re\rgx;
/**
 * 数据处理类
 * @author reginx
 */
class filter extends rgx {

    /**
     * 数据验证规则
     *
     * @var array
     */
    public static $rules = [

        // 键名小写
        'all'         => '/^.*$/',
        'cn_id'       => '/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i',
        'currency'    => '/^\d+(\.\d+)?$/',
        'double'      => '/^[-\+]?\d+(\.\d+)?$/',
        'email'       => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
        'email_code'      => '/^[A-Za-z0-9]{4}$/',
        'english'     => '/^[A-Za-z]+$/',
        'integer'     => '/^[-\+]?\d+$/',
        'lat'         =>'/^((\d|[1-8]\d)°(\d|[1-5]\d)′(\d|[1-5]\d)(\.\d{1,2})?″N$)|(90°0′0″N$)/',
        'lng'         =>'/^((\d|[1-9]\d|1[0-7]\d)°(\d|[0-5]\d)′(\d|[0-5]\d)(\.\d{1,2})?″E$)|(180°0′0″?E$)/',
        'mobile'      => '/^1\d{10}$/',
        'number'      => '/^\d+$/',
        'passwd'      => '/^[^\s]{2,37}$/',
        'phone'       => '/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/',
        'price'       => '/^\d+(\.\d+)?$/',
        'qq'          => '/^[1-9]\d{4,12}$/',
        'require'     => '/^.+$/s',
        'uid'         => '/^[A-Za-z0-9_]{2,30}$/',
        'url'         => '/^https?:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/',
        'wechat'         => '/^[a-zA-Z]{1}[-_a-zA-Z0-9]{5,19}$/',
        'zip'         => '/^[1-9]\d{5}$/',
        'hex_color'   => '/^#[0-9a-f]{3}([0-9a-f]{3})?$/i',
        'file_path'   => '/^[\w]+\/[\w\/\-]+\.\w+$/i',
    ];

    /**
     * 类型转换为 string
     * @param string $value
     * @return string
     */
    public static function char ($value) {
        return self::html($value);
    }

    /**
     * 类型转换为 int
     * @param string $value
     * @return integer
     */
    public static function int ($value) {
        return (int) $value;
    }

    /**
     * 类型转换为 float
     * @param string $value
     * @return float
     */
    public static function float ($value) {
        return (float) $value;
    }

    /**
     * 静态方法 调用不存在的方法
     * @param unknown $method
     * @param array $argv
     * @return NULL
     */
    public static function __callstatic ($method, $argv = []) {
        return null;
    }

    /**
     * 判断是否为 手机号码
     * @param string $str
     * @return bool
     */
    public static function is_mobile ($str) {
        return preg_match(self::$rules['mobile'], $str);
    }

    /**
     * 检测是否是个有效的正浮点数
     * @param string $str
     * @return boolean
     */
    public static function is_positive_float ($str) {
        if (preg_match(self::$rules['currency'], $str)) {
            return $str > 0;
        }
        return false;
    }

    /**
     * 检测是否是个有效的价格值
     * @param string $str
     * @return boolean
     */
    public static function is_positive_price ($str) {
        if (preg_match(self::$rules['currency'], $str)) {
            return $str > 0;
        }
        return false;
    }

    /**
     * 检测是否是个有效的正整数值
     * @param string $str
     * @return boolean
     */
    public static function is_positive_int ($str) {
        if (preg_match(self::$rules['number'], $str)) {
            return $str > 0;
        }
        return false;
    }

    /**
     * 获取正则表达式
     * @param string $str
     * @return mixed
     */
    public static function regexp ($str) {
        return filter_var($str, FILTER_VALIDATE_REGEXP);
    }

    /**
     * 获取 url
     * @param string $str
     * @return mixed
     */
    public static function url ($str) {
        return filter_var($str, FILTER_VALIDATE_URL);
    }

    /**
     * 获取 ip
     * @param string $str
     * @return mixed
     */
    public static function ip ($str) {
        return filter_var($str, FILTER_VALIDATE_IP);
    }

    /**
     * 获取 Email
     * @param string $str
     * @return mixed
     */
    public static function email ($str) {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }

    /**
     * 获取原始内容
     * @param string $str
     * @return unknown
     */
    public static function source ($str) {
        return $str;
    }

    /**
     * 获取安全字串
     * @param string $str
     * @return string
     */
    public static function text ($str) {
        $str = trim($str);
        if (!empty($str)) {
            $str = htmlspecialchars(
                    preg_replace('/\&.+?\;/i', '', self::rmtags($str)),
                    ENT_HTML_QUOTE_SINGLE, 'utf-8');
        }
        return $str;
    }

    /**
     * 过滤HTML标签
     * @param string $str
     * @return string|mixed
     */
    public static function rmtags ($str) {
        if (empty($str) && !is_string($str)) {
            return '';
        }
        $str = htmlspecialchars_decode($str, ENT_HTML_QUOTE_SINGLE);
        $str = preg_replace('/\<style(.*?)>.*?\<\/style\>/is', '', $str);
        $str = preg_replace('/\<script(.*?)>.*?\<\/script\>/is', '', $str);
        $str = preg_replace('/\<iframe(.*?)>.*?\<\/iframe\>/is', '', $str);
        $str = strip_tags($str);
        return str_replace('\\', '&#092;', trim($str));
    }

    /**
     * 去除指定的html标签
     * @param string $str
     * @param string $tags
     * @return string
     */
    public static function cleartags ($str, $tags = 'div,ul,li,embed,span,a') {
        $str = htmlspecialchars_decode($str, ENT_HTML_QUOTE_SINGLE);
        $str = preg_replace('/\<\!\-\-.*?\-\->/is', '', $str);
        $str = preg_replace('/\<style(.*?)>.*?\<\/style\>/is', '', $str);
        $str = preg_replace('/\<script(.*?)>.*?\<\/script\>/is', '', $str);
        $str = preg_replace('/\<iframe(.*?)>.*?\<\/iframe\>/is', '', $str);
        $str = preg_replace(
                '/\<\/?\s*(' . str_replace(',', '|', $tags) . ').*?\>/is', '',
                $str);
        return trim($str);
    }

    /**
     * 默认html过滤
     * @param string $str
     * @return mixed
     */
    public static function html ($str) {
        $str = htmlspecialchars_decode($str, ENT_HTML_QUOTE_SINGLE);
        $str = preg_replace('/\<style(.*?)>.*?\<\/style\>/is', '', $str);
        $str = preg_replace('/\<script(.*?)>.*?\<\/script\>/is', '', $str);
        $str = preg_replace('/javascript\:.*?[\"\']?/is', '#', $str);
        $str = htmlspecialchars($str, ENT_HTML_QUOTE_SINGLE, 'utf-8');
        return str_replace('\\', '&#092;', trim($str));
    }

    /**
     * 默认过滤
     * @param string $str
     * @return string
     */
    public static function normal ($str) {
        return htmlspecialchars(self::rmtags($str), ENT_HTML_QUOTE_SINGLE, 'utf-8');
    }

    /**
     * 转换成时间戳
     * @param string $str
     * @return number
     */
    public static function timestamp ($str) {
        return strtotime($str) ?: 0;
    }

    /**
     * 解码转换为 HTML
     * @param string $str
     * @return string
     */
    public static function code ($str) {
        return htmlspecialchars(htmlspecialchars_decode(trim($str)), 
            ENT_HTML_QUOTE_SINGLE, 'utf-8');
    }

    /**
     * 是否是合法的账号格式 (支持邮箱, 中文, 英文,数字等非特殊字符组合)
     * @param string $str
     * @return boolean
     */
    public static function is_account ($str) {
        return !preg_match(
                '/(\s|\"|\#|\$|\%|\&|\'|\*|\+|\,|\/|\;|\<|\=|\>|\\\|\^|\`|\||\~|\:\(|\)|\[|\]|\?)+/u',
                $str);
    }

    /**
     * 过滤敏感字符
     * @param unknown $str
     * @return mixed
     */
    public static function ult ($str) {
        return preg_replace(
                '/(\s|\"|\#|\$|\%|\&|\'|\*|\+|\,|\/|\;|\<|\=|\>|\@|\\\|\^|\`|\||\~|:)+/u',
                '', self::text($str));
    }

    /**
     * 转换为json格式
     * @param string $value
     * @return string
     */
    public static function json_ecsape ($value) {
        return json_encode($value, JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * json格式转换为标量
     * @param string $value
     * @return mixed
     */
    public static function json_unecsape ($value) {
        return json_decode(str_replace([
            '\u0022',
            'u0022',
            "\r\n",
            "\r",
            "\n"
        ], [
            '\\"',
            '\\"',
            " ",
            " ",
            " "
        ], $value), 1);
    }

    /**
     * 内容转义
     * @param string $value
     * @return string
     */
    public static function ecsape ($value) {
        if (!is_numeric($value)) {
            $value = addslashes($value);
        }
        return $value;
    }

    /**
     * 内容反转义
     * @param string $value
     * @param string $strip
     * @return mixed
     */
    public static function unecsape ($value, $strip = true) {
        if (!is_numeric($value)) {
            $value = str_replace('&#092;', '\\', htmlspecialchars_decode($value, ENT_HTML_QUOTE_SINGLE));
            if ($strip) {
                $value = stripslashes($value);
            }
        }
        return $value;
    }

    /**
     * 判断是否是一个有效的mysql year列取值 范围  1901 ~ 2155
     * @param string $str
     * @return boolean
     */
    public static function is_mysql_year ($str) {
        return $str >= 1901 && $str <= 2155;
    }

    /**
     * 判断是否是mysql列所支持的date格式 1000-01-01 ~ 9999-12-31
     * @param string $str
     * @return boolean
     */
    public static function is_mysql_date ($str) {
        $ret = false;
        if (preg_match('/^[1-9]\d{3}-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2]\d|3[0-1])$/', $str)) {
            list($year, $month, $day) = explode('-', $str, 3);
            if (checkdate((int)$month, (int)$day, (int)$year)) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * 判断是否是有效的mysql datetime 列取值 (暂时不支持小数位)
     * @param string $str
     * @return boolean
     */
    public static function is_mysql_datetime ($str) {
        $ret = false;
        if (preg_match(
                '/^[1-9]\d{3}-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2]\d|3[0-1])( ([0-1]?[0-9]|2[0-3]):[0-5]?[0-9]:[0-5]?[0-9])?$/', $str)) {
            list($year, $month, $day) = explode('-', explode(' ', $str, 2)[0], 3);
            if (checkdate((int)$month, (int)$day, (int)$year)) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * 判断是否是有效的mysql timestamp 列取值, 范围 : 1970-01-01 00:00:01 ~ 2038-01-19 03:14:07
     * @param string $str
     * @return boolean
     */
    public static function is_mysql_timestamp ($str) {
        $ret = false;
        // 限制到2037-12-31...
        if (preg_match(
                '/^(19[7-9][0-9]|20[0-2][0-9]|203[0-7])-(0?[1-9]|1[0-2])-(0?[1-9]|[1-2]\d|3[0-1])( ([0-1]?[0-9]|2[0-3]):[0-5]?[0-9]:[0-5]?[0-9])?$/', $str)) {
            list($year, $month, $day) = explode('-', explode(' ', $str, 2)[0], 3);
            if (checkdate((int)$month, (int)$day, (int)$year)) {
                $ret = true;
            }
        }
        return $ret;
    }

    /**
     * 是否是有效的mysql time 列取值 -838:59:59 ~ 838:59:59
     * @param string $str
     * @return boolean
     */
    public static function is_mysql_time ($str) {
        $ret = false;
        if (preg_match('/^-?(\d{3}):[0-5]?[0-9]:[0-5]?[0-9]$/', $str)) {
            $ret =  abs(explode(':', $str)[0]) <= 838;
        }
        return $ret;
    }
}
if (!defined('ENT_HTML_QUOTE_SINGLE')) {
    define('ENT_HTML_QUOTE_SINGLE', 1);
}