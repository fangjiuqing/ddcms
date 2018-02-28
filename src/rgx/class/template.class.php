<?php
namespace re\rgx;
/**
 * 模板解析处理类
 * @author reginx
 */
class template extends rgx {

    /**
     * 配置
     * @var array
     */
    private $_conf = [
        'ob'        => true,
        'native'    => false,
        'style'     => 'default',
        'tpl_pre'   => '{',
        'tpl_suf'   => '}',
        'cur_mod'   => false,
        'lang'      => 'zh-cn',
        'charset'   => 'utf-8',
        'allow_php' => false
    ];

    /**
     * 数据变量
     * @var array
     */
    private $_vars = [];

    /**
     * 当前模板原文件
     * @var string
     */
    private $_ctplfile = 'unkown';

    /**
     * 获取单例模板引擎对象
     * @param array $conf
     * @return \re\rgx\template
     */
    public static function get_instance ($conf = []) {
        static $tplobj = null;
        if (empty($tplobj)) {
            $tplobj = new template($conf);
        }
        return $tplobj;
    }

    /**
     * 清除当前app解析生成的临时文件
     * @param array $app
     * @return number
     */
    public static function flush ($app = []) {
        return misc::rmrf(TEMP_PATH . ($app['name'] ?: APP_NAME) . '_' .
                ($app['id'] ?: APP_ID));
    }

    /**
     * 架构方法
     * @param array $conf
     */
    private function __construct ($conf = []) {
        if (!empty($conf)) {
            $this->_conf = array_merge($this->_conf, $conf);
        }
        $this->_conf['app_name'] = IS_ALIAS ? D_ALIAS_ID : APP_NAME;

        if (!is_dir(TEMP_PATH . $this->_conf['app_name'] . '_' . APP_ID)) {
            misc::mkdir(TEMP_PATH . $this->_conf['app_name'] . '_' . APP_ID);
        }
        // 输出的缓存目录
        $this->_conf['out_dir'] = realpath(TEMP_PATH . $this->_conf['app_name']  . '_' . APP_ID) . DS;
        // 源模板文件所在目录
        if (defined('D_ALIAS_TPL')) {
            $this->_conf['tpl_dir'] = IS_ALIAS && IS_ALIAS_TPL ? D_ALIAS_TPL : TPL_PATH;
        }
        else {
            $this->_conf['tpl_dir'] = TPL_PATH;
        }
    }

    /**
     * 设置/获取 style 名
     * @param string $val
     * @return mixed
     */
    public function style ($val = null) {
        if (!empty($val)) {
            $this->_conf['style'] = $val;
        }
        else {
            return $this->_conf['style'];
        }
    }

    /**
     * 获取已设置的数据
     * @param string $key
     * @return mixed
     */
    public function get ($key) {
        return isset($this->_vars[$key]) ? $this->_vars[$key] : null;
    }

    /**
     * 数据变量赋值
     * @param string $key
     * @param mixed  $value
     */
    public function assign ($key, $value) {
        if (($pos1 = strpos($key, '[')) !== false && 
                ($pos2 = strpos($key, ']')) !== false) {
            $skey = substr($key, $pos1 + 1, $pos2 - $pos1 - 1);
            $key = substr($key, 0, $pos1);
            if ($skey == '') {
                $this->_vars[$key][] = $value;
            }
            else {
                $this->_vars[$key][$skey] = $value;
            }
        }
        else {
            $this->_vars[$key] = $value;
        }
    }

    /**
     * 渲染输出模板
     * @param string $file
     * @param string $ctype
     * @param array $headers
     */
    public function display ($file, $ctype = "text/html", $headers = []) {
        if (!IS_CLI) {
            header('X-Powered-By: RGX v' . RGX_VER);
            header("Content-Type: " . $ctype . "; charset={$this->_conf['charset']}");
            foreach ((array)$headers as $v) {
                header($v);
            }
        }
        exit($this->fetch($file, false));
    }

    /**
     * 常量定义
     */
    public function define_ctpl_url () {
        if (IS_ALIAS && D_ALIAS_APPEND == 'default') {
            define ('CTPL_URL', BASE_URL . APP_NAME . '/template/' . 
                $this->_conf['style'] . '/');
        }
        else if (IS_ALIAS && D_ALIAS_APPEND != 'default') {
            define ('CTPL_URL', BASE_URL . D_ALIAS_APPEND . 
                '/template/' . $this->_conf['style'] . '/');
        }
        else {
            define ('CTPL_URL', APP_URL . 'template/' . $this->_conf['style'] . '/');
        }
    }

    /**
     * 获取模板渲染输出后的内容
     * @param string $file
     * @param string $outbuf
     * @return string
     */
    public function fetch ($file, $outbuf = true) {
        $file .= ($this->_conf['native'] ? '.php' : '.html');
        if (!defined('CTPL_URL')) {
            $this->define_ctpl_url();
        }
        // 原始文件路径
        $this->_ctplfile = $sfile = $this->get_source_path($file);

        // 非Debug模式下. 清空一切非模板输出
        if (RUN_MODE != 'debug' && $outbuf) {
            ob_end_clean();
        }
        // 默认开启缓冲
        if ($this->_conf['ob']) {
            ob_start();
            ob_implicit_flush(0);
        }
        extract($this->_vars);
        unset($this->_vars);

        // 使用原生 php 作为模板文件
        if ($this->_conf['native']) {
            $cfile = $this->_ctplfile;
        }
        // 使用模板文件
        else {
            // 缓存文件路径
            $cfile = $this->get_cache_path($file);
            // create temp dir
            if (!is_dir(dirname($cfile))) {
                misc::mkdir(dirname($cfile));
            }
            // 检测模板是否过期
            if (RUN_MODE == 'debug' || $this->check_expired($cfile, $sfile)) {
                $this->parse_tpl($cfile, $sfile);
            }
        }

        include ($cfile);
        if ($this->_conf['ob'] && $outbuf) {
            $content = ob_get_clean();
            delegate::trigger('template::fetch', delegate::AFTER, $content);
            return $content;
        }
    }
    
    /**
     * 解析生成临时文件
     * @param string $tmpfile
     * @param string $sfile
     */
    public function parse_tpl ($tmpfile, $sfile) {
        $html = file_get_contents($sfile);
        // replace <!--{,}--> to { , }
        $html = preg_replace(
                '/\<\!\-\-' . preg_quote($this->_conf['tpl_pre']) .
                         '\s*(.+?)\s*' . preg_quote($this->_conf['tpl_suf']) .
                         '\-\-\>/i', '{\1}', $html);
        // include abc.tpl.html
        $this->get_inc_file($html);

        if (!$this->_conf['allow_php']) {
            $html = preg_replace('/<\?php.+\?>/i', '' , $html);
        }
        // comments
        $html = preg_replace('/\s*\{\s*\/\/.+?\s*\}\s*/i', "\n", $html);

        // $var
        $html = preg_replace_callback('/\{(\$[^\}]*?)\}/i', [$this, 'parse_var'], $html);
        // foreach
        $html = preg_replace_callback(
                '/\{\s*foreach\s+(\$[^\s]+)\s+(\$[\w]+)\s+(\$?[\w]+)\s*\}/i',
                [$this, 'parse_foreach'], $html);
        // endforeach
        $html = preg_replace('/\{\s*\/foreach\s*\}/i', '<?php endforeach;?>', $html);
        // break
        $html = preg_replace('/\{\s*break\s*\}/i', '<?php break;?>', $html);
        // if
        $html = preg_replace('/\{[\040\t]*if\s+(.+?)\s*\}/i', '<?php if (\1):?>', $html);
        // else if
        $html = preg_replace('/\{\s*else\s*if\s+(.*?)\s*\}/i', '<?php elseif (\1):?>', $html);
        // elif
        $html = preg_replace('/\{\s*elif\s+(.*?)\s*\}/i', '<?php elseif (\1):?>', $html);
        // else
        $html = preg_replace('/\{\s*else\s?\s*\}/i', '<?php else:?>', $html);
        // end if
        $html = preg_replace('/\{\/if\s*?\}\s*/i', '<?php endif;?>', $html);
        // constant
        $html = preg_replace_callback('/\{\s?__([\w\-_]*?)__\s?\}/is', [$this, 'parse_constant'], $html);
        // for $x in range(0 , 10 , 1)
        $html = preg_replace(
                '/\{[\040\t]?for\s+\$?(.*?)\s+in\s+range\(\s*([^\s\,]*?)\s*,\s*([^\s\,]*?)\s*,\s*([^\s]*?)\s*\)\s*\}/i',
                '<?php for($\1=\2;(\3>\2 ? ($\1<\3) : ($\1>\3));$\1+=\4):?>',
                $html);
        // for $x in range(0 , 10)
        $html = preg_replace(
                '/\{\s?for\s+\$?(.*?)\s+in\s+range\(\s*([^\s\,]*?)\s*,\s*(.*?)\)\s*\}/i',
                '<?php for($\1=\2;$\1<\3;$\1++):?>', $html);
        // end for
        $html = preg_replace('/\{\/for\s*\}/i', '<?php endfor;?>', $html);
        // lang
        $html = preg_replace_callback('/\{lang\s*\:\s*(.*?)\}/is', [$this, 'parse_lang'], $html);
        // function
        $html = preg_replace('/\{\s*:(.*?)\s*?\}/i', '<?php echo(\1);?>', $html);
        // dynamic url
        $html = preg_replace('/\{\s?url\:\(?(.*?)\)?\}/i', '<?php echo(R\\router::url(\\1)); ?>', $html);
        // static url
        $html = preg_replace_callback('/\{\s*surl\:\(?(.*?)\)?\}/i', [$this, 'parse_url'], $html);
        // execute time tag
        $html = preg_replace('/\{\s?\@TIME(.*?)\s*?\}/i',
                '<?php printf("%.3f", (microtime(TRUE) - START_TIME)\1); ?>',
                $html);
        // dynamic constant
        $html = preg_replace('/\{\s?_([\w\-_\.]+?)_\s?\}/is',
                '<?php echo(R\CFG(strtolower("\1")) ?: strtolower("\1")); ?>',
                $html);
        // token
        $html = preg_replace('/\{\s*token\s+[\'\"]?(.*?)[\'\"]?\s*\}/is', '<?php echo($GLOBALS[\'_CMOD\']->token("\\1")); ?>', $html);
        // eval
        $html = preg_replace('/\{\s*eval\s+(.*?)\s*\}/is', '<?php \1?>', $html);
        // block
        $html = preg_replace(
                '/\{block\s*\:\s*\$([^,\}]+)\s*,\s*([^\}]+)\}/is',
                '<?php \$\1 = block::getdata(\'\2\'); ?>', $html);
        $html = preg_replace('/(\s)+\<\?php(.*?)\?\>/ui', "\\1<?php\\2?>", $html);
        $html = preg_replace('/\<\?php(.*?)\?\>(\s)+/ui', "<?php\\1?>\\2", $html);
        $html = "<?php " .
                "namespace " . NS . ";use re\\rgx as R;" .
                "!defined('IN_RGX') && exit('Access Denied'); unset(\$this);" .
                "?>" . $html;
        file_put_contents($tmpfile, $html, LOCK_EX);
    }

    /**
     * callback 解析 url 标签 
     * @param array $matches
     * @return mixed
     */
    private function parse_url ($matches = []) {
        $str = trim(str_replace(["'", "\""], '', $matches[1]));
        return call_user_func_array(['\re\rgx\router', 'url'], 
                array_map('trim', explode(',', $str)));
    }

    /**
     * callback 解析 语言 标签
     * @param array $matches
     * @return string
     */
    private function parse_lang ($matches = []) {
        $expression = trim($matches[1]);
        if (substr($expression, 0, 1) == '$') {
            return "<?php echo(\$GLOBALS['_TPL']->lang($expression)); ?>";
        }
        return $this->lang($expression);
    }

    /**
     * callback 解析 常量 标签
     * @param array $matches
     * @throws exception
     * @return string
     */
    private function parse_constant ($matches = []) {
        // 优先返回常量值
        if (defined(strtoupper($matches[1]))) {
            return constant(strtoupper($matches[1]));
        }
        else if (CFG($matches[1])) {
            return CFG($matches[1]);
        }
        else {
            throw new exception(LANG('undefined constant', $matches[1]), 
                exception::NOT_EXISTS);
        }
    }

    /**
     * callback 解析 foreach 标签
     * @param array $matches
     * @return string
     */
    private function parse_foreach ($matches = []) {
        $ret = "<?php unset({$matches[2]}, {$matches[3]}); {$matches[2]}_index = 0; ";
        $ret .= "foreach ((array){$matches[1]} as {$matches[2]} => {$matches[3]}): ";
        return $ret . "{$matches[2]}_index ++;?>";
    }

    /**
     * callback 解析 变量 标签
     * @param unknown $matches
     * @throws exception
     * @return string
     */
    private function parse_var ($matches) {
        $allows = ['cut', 'thumb', 'html', 'escape', 'date', 'amount', 'json', 'percent'];
        $tag = explode('|', trim($matches[1]));
        $var = trim(array_shift($tag));

        foreach ((array) $tag as $k => $v) {
            $temp = explode(',', trim($v));
            $temp[0] = trim($temp[0]);
            $temp[1] = isset($temp[1]) ? trim($temp[1]) : null;
            $is_var  = preg_match('/^\s*\$.+?$/', $temp[1] ?: '');

            if (empty($temp[1])) {
                switch ($temp[0]) {
                    // {$foo|thumb}
                    case 'thumb':
                        $var = "R\\image::get_thumb_name({$var})";
                        break;
                    // {$foo|date}
                    case 'date':
                        $var = "date('Y-m-d', {$var})";
                        break;
                    // {$foo|html}
                    case 'html':
                        $var = "htmlspecialchars_decode({$var}, ENT_QUOTES)";
                        break;
                    // {$foo|escape}
                    case 'escape':
                        $var = "htmlspecialchars({$var}, ENT_QUOTES)";
                        break;
                    // {$foo|slash}
                    case 'slash':
                        $var = "addslashes({$var})";
                        break;
                    // {$foo|rmslash}
                    case 'rmslash':
                        $var = "stripslashes({$var})";
                        break;
                    // {$foo|int}
                    case 'int':
                        $var = "intval({$var})";
                        break;
                }
            }
            else {
                switch ($temp[0]) {
                    // {$foo|thumb,300x200}
                    case 'thumb':
                        if ($is_var) {
                            $var = "R\\image::get_thumb_name({$var} , {$temp[1]})";
                        }
                        else {
                            $var = "R\\image::get_thumb_name({$var} , '{$temp[1]}')";
                        }
                        break;
                    // {$foo|cut,32,..}
                    case 'cut':
                        $var = "R\\misc::cut_str({$var}, " . intval($temp[1]) . 
                                    (isset($temp[2]) ? (", '{$temp[2]}'") : '') . ")";
                        break;
                    // {$foo|date,Y-m-d H:i:s}
                    case 'date':
                        $var = "date('{$temp[1]}' , {$var})";
                        break;
                    // {$foo|json,encode} or {$foo|json,decode}
                    case 'json':
                        if ($temp[1] == 'decode') {
                            $var = "json_decode({$var}, true)";
                        }
                        else if ($temp[1] == 'encode') {
                            $var = "json_encode({$var}, JSON_UNESCAPED_UNICODE)";
                        }
                        else {
                            throw new exception(
                                LANG('invalid template tag', misc::relpath($this->_ctplfile) . " => " . "{$temp[0]},$temp[1]"),
                                exception::INVALID_REGEX
                            );
                        }
                        break;
                    // {$foo|percent,$bar}
                    case 'percent':
                        $var = "R\\misc::pencent({$var} , {$temp[1]})";
                        break;
                    default:
                        throw new exception(
                            LANG('invalid template tag', misc::relpath($this->_ctplfile) . " => " . $temp[0]),
                            exception::INVALID_REGEX
                        );
                        break;
                }
            }
        }
        return "<?php echo($var);?>";
    }

    /**
     * 解析 include 标签
     * @param ref $html
     * @param integer $limit
     */
    private function get_inc_file (&$html, $limit = 1) {
        $files = $tmp = array();
        preg_match_all('/\{\s*?include\s+(.+?)\s*?\}/i', $html, $files);
        for ($j = 0; $j < sizeof($files[1]); $j ++) {
            $repl = array();
            // 新增 include 传参特性
            // {include abc.tpl.html #param0, param1, param2} 参数不限
            // 调用方式 ${0}, ${1}, ${2} ...
            if (($pos = strpos($files[1][$j], '#')) !== false) {
                $file = $this->get_source_path(substr($files[1][$j], 0, $pos - 1));
                $param = explode(',', trim(substr($files[1][$j], $pos + 1)));
                if (!empty($param)) {
                    // 动态参数列表
                    foreach ($param as $k => $v) {
                        $repl['${' . $k . '}'] = trim($v);
                        // 变量
                        if (substr($repl['${' . $k . '}'], 0, 1) == '$') {
                            //$repl['${' . $k . '}'] = '{' . $repl['${' . $k . '}'] . '}';
                        }
                    }
                }
            }
            else {
                $file = $this->get_source_path($files[1][$j]);
            }
            if (!file_exists($file) ) {
                throw new exception(LANG('file not found', misc::relpath($file)), 'TFNF', 1, __METHOD__);
            }
            $temp = file_get_contents($file);
            $temp = preg_replace(
                    '/\s*\<\!\-\-' . preg_quote($this->_conf['tpl_pre']) .
                             '\s*(.+?)\s*' . preg_quote($this->_conf['tpl_suf']) .
                             '\-\-\>\s*/i', '{\1}', $temp);
            if (!empty($repl)) {
                $temp = str_replace(array_keys($repl), $repl, $temp);
            }
            // 默认填充 (防止出现语法错误)
            else {
                $temp = preg_replace('/\$\{\d+\}/', 'nil', $temp);
            }
            $html = str_replace($files[0][$j], $temp, $html);
            $temp = null;
            unset($temp);
        }
        // max limit 3
        if (preg_match('/\{\s*?include\s+(.*?)\s*?\}/i', $html) && $limit <= 3) {
            $this->get_inc_file($html, $limit + 1);
        }
    }

    /**
     * 检查缓存模板文件是否可用
     * @param string $tmpfile
     * @param string $sfile
     * @return boolean
     */
    private function check_expired ($tmpfile, $sfile) {
        $ret = false;
        if (!is_file($tmpfile) || !file_exists($tmpfile)) {
            $ret = true;
        }
        return $ret ? $ret : filemtime($tmpfile) < filemtime($sfile);
    }

    /**
     * 解析模板文件路径
     * @example index.html , default:index.html , admin@default:index.html
     * @abstract APP@style:tplfile
     * @param string $sfile
     * @return string
     */
    private function get_source_path ($sfile) {
        $fpath = $this->_conf['tpl_dir'];
        if (($pos = strpos($sfile, ':')) !== false) {
            $fpath .= substr($sfile, 0, $pos) . DS;
            $sfile = substr($sfile, $pos + 1, strlen($sfile));
        }
        else {
            $fpath .= $this->_conf['style'] . DS;
        }

        $fpath = $fpath . $sfile;
        // 自动添加 .html
        $fpath .= (substr($fpath, -5) == '.html' ? '' : '.html');

        if ($fpath === false || ! is_file($fpath)) {
            throw new exception(LANG('not exists', misc::relpath($fpath)), exception::NOT_EXISTS);
        }
        return realpath($fpath);
    }

    /**
     * 语言解析
     * @param array $args
     * @return string
     */
    public function lang ($args = []) {
        $keys = is_array($args) ? $args : explode(',',
                preg_replace('/[\'|\"]*/', '', $args));
        if (!empty($keys)) {
            $keys = array_map('trim', $keys);
            for ($i = 0; $i < sizeof($keys); $i ++) {
                if (!empty($keys[$i]) && $keys[$i] != '') {
                    $keys[$i] = isset($GLOBALS['_RL'][$keys[$i]]) ? $GLOBALS['_RL'][$keys[$i]] : $keys[$i];
                }
            }
            $format = array_shift($keys);
            $flen = sizeof(preg_split('/\%\w/i', $format));
            // 使数组元素总数与占位符数目相对应
            while (sizeof($keys) < $flen) {
                $keys[] = '';
            }
            return vsprintf($format, $keys);
        }
        return empty($keys) ? '' : join('-', $keys);
    }

    /**
     * 获取模板文件对应的缓存文件路径
     * @param string $file
     * @return string
     */
    private function get_cache_path ($file) {
        return $this->_conf['out_dir'] . sprintf('%010X', 
                    crc32($this->_conf['style'] . '_' . $this->_conf['lang'] . '_' . $file)) .
                     '.php';
    }
}