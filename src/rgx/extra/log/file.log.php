<?php
namespace re\rgx;
/**
 * 文件日志类
 * @author reginx
 */
class file_log extends log {

    /**
     * 内容队列
     *
     * @var array
     */
    private $_queue = [];

    /**
     * 资源句柄
     *
     * @var array
     */
    private $_handle = [];

    /**
     * 当前日志文件
     *
     * @var string
     */
    private $_cur   = 'default';

    /**
     * 配置信息
     * @var array
     */
    protected $config = null;

    /**
     * 架构方法
     * @param unknown $config
     */
    public function __construct ($config) {
        $this->config = $config;
    }

    /**
     * 初始化
     * {@inheritDoc}
     * @see \re\rgx\log::init()
     */
    public function init ($key = null) {
        $this->_cur = empty($key) ? 'common' : $key;
        if (!isset($this->_handle[$this->_cur])) {
            $this->_handle[$this->_cur] = fopen($this->_get_file(), 'a+');
        }
    }

    /**
     * 获取文件绝对路径
     * @return string
     */
    private function _get_file () {
        $file = DATA_PATH . 'log/' . date('Y-m-d', app::get_time()) . "_" .  $this->_cur . 
                    ($this->config['dev'] ? '.log.txt' : '.log.php');
        if (!is_dir(dirname($file))) {
            misc::mkdir(dirname($file));
        }
        return $file;
    }

    /**
     * 写入
     * {@inheritDoc}
     * @see \re\rgx\log::write()
     */
    public function write ($msg, $trace_log = false, $trace_stack = null) {
        $_msg = [];
        if (!is_array($msg)) {
            $_msg['msg'] = $msg;
            $_msg['extra'] = 'Nil';
        }
        else {
            $_msg['msg'] = array_shift($msg);
            $_msg['msg'] = !is_array($_msg['msg']) ? $_msg['msg'] :
                    json_encode($_msg['msg'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $_msg['extra'] = empty($msg) ? 'Nil' : array_shift($msg);
        }

        $output  = ($this->config['dev'] ? '' : "<?php" . PHP_EOL)
            . "/*" . PHP_EOL
            . " * @ip   " . app::get_ip() . PHP_EOL
            . " * @app  " . app::get_url() . PHP_EOL
            . " * @url  {$_SERVER['REQUEST_URI']}" . PHP_EOL
            . " * @date " . (date('Y-m-d H:i:s ', REQUEST_TIME)) . PHP_EOL
            . " * @desc " . $_msg['msg'] . PHP_EOL
            . " * @extra " . str_replace("\n", "\n    ", $_msg['extra']) . PHP_EOL . PHP_EOL;

        if ($trace_log) {
            $trace = $trace_stack ?: debug_backtrace(false);
            for ($i = 0; $i < count($trace) - 1; $i ++) {
                $trace[$i]['args'] = array_map(function ($row) {
                    if (is_subclass_of($row, 'rgx', false)) {
                        return "[Object {$row->__toString()}]";
                    }
                    else if (is_array($row)) {
                        return "[Array]";
                    }
                    else if (is_callable($row)) {
                        return "{closure}";
                    }
                    else {
                        return $row;
                    }
                }, $trace[$i]['args'] ?: []);
                $output .= ' # line:' .
                        sprintf('%05d', empty($trace[$i]['line']) ? 0 : $trace[$i]['line']);
                $output .= ' file : ' . misc::relpath($trace[$i]['file']);
                $output .= ' ' . (empty($trace[$i]['class']) ? '' : $trace[$i]['class']);
                $output .= (empty($trace[$i]['type']) ? '' : $trace[$i]['type']);
                $output .= (empty($trace[$i]['function']) ? '' : $trace[$i]['function']) . "(";
                $output .= empty($trace[$i]['args']) ? '' : join(',', str_replace("\n", "\n    ", $trace[$i]['args']));
                $output .= ")" . PHP_EOL;
            }
        }
        fwrite($this->_handle[$this->_cur], $output . PHP_EOL . ($this->config['dev'] ? '' : ("*/" . PHP_EOL . "?>")));
    }

    /**
     * 刷新缓冲区
     * {@inheritDoc}
     * @see \re\rgx\log::flush()
     */
    public function flush ($key = null) {
        if (!empty($key) && isset($this->_handle[$key])) {
            fflush($this->_handle[$key]);
        }
        else {
            foreach ((array)$this->_handle as $v) {
                fflush($v);
            }
        }
    }

    /**
     * 析构函数
     */
    public function __destruct () {
        foreach ((array)$this->_handle as $v) {
            fflush($v);
            fclose($v);
        }
    }
}