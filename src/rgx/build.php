<?php
/**
 * 构建基类
 * @author reginx
 */
class build {
    
    /**
     * 版本名称
     * @var string
     */
    public $version_name = '20171212_RC';
    
    /**
     * 永远的 1.0
     * @var string
     */
    public $version_code = '1.0.0';

    /**
     * 换行符
     * @var string
     */
    public $eol = "\r\n";

    /**
     * 帮助信息数组
     * @var array
     */
    public $help = [
        "",
        'Usage: php build.php <cmd>',
        "",
        "where <cmd> is one of: app, table",
        "",
        "php build.php <cmd> -help\t\tquick help on <cmd>",
        "",
        ""
    ];
    
    /**
     * 当前命令
     * @var string
     */
    public $cmd = '';
    
    /**
     * 命令行输入参数
     * @var array
     */
    public $argv = [];
    
    /**
     * 当前目录
     * @var unknown
     */
    public $dir = './';
    
    /**
     * 架构方法
     */
    public function __construct () {
        if (!isset($_SERVER['PWD'])) {
            $this->halt('invalid PWD');
        }

        $this->cmd  = join(' ', $_SERVER['argv']);
        $this->dist_dir = realpath($_SERVER['PWD']);
        $this->src_dir  = realpath(__DIR__);
        
        if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50500) {
            $this->halt("\nRequires at least version PHP v5.50\n" . PHP_EOL);
        }
        if (php_sapi_name() !== 'cli') {
            $this->halt("\nPlease use the command line to run\n" . PHP_EOL);
        }
        
        if (empty($this->argv)) {
            $this->argv = array_slice($_SERVER['argv'], 1);
            foreach ($this->argv as $k => $v) {
                if (preg_match('/^\-\-.+$/iu', $v)) {
                    $item = explode('=', preg_replace('/^\-\-/i', '', $v));
                    $this->argv[trim($item[0])] = trim($item[1]);
                }
            }
        }
    }
    
    /**
     * 获取命令
     * @return string
     */
    public function get_cmd () {
        $ret = [
            $_SERVER['PHP_SELF']
        ];
        foreach ((array)$this->argv as $k => $v) {
            if (!is_numeric($k)) {
                $ret[] = "--{$k}" . ($v ? ("=" . str_replace('*', '\*', $v)) : '');
            }
        }
        return "php " . join(' ', $ret);
    }
    
    /**
     * 获取外部输入
     * @param string $desc
     * @param mixed  $default
     * @return string
     */
    public final function get_input ($desc = '', $default = null) {
        $ret = '';
        $this->msg(
            $desc . 
            ($default ? (" ({$default}) : ") : ' : ')
        );
        fscanf(STDIN, '%s', $ret);
        return $ret ?: $default;
    }
    
    /**
     * 获取命令行参数
     * @param string $key
     * @return string|mixed
     */
    public function get_param ($key) {
        return isset($this->argv[$key]) ? $this->argv[$key] : '';
    }
    
    /**
     * 是否存在某参数
     * @param string $key
     * @return boolean
     */
    public function has_param ($key) {
        return isset($this->argv[$key]);
    }
    
    /**
     * 输出消息
     * @param mixed $msg
     */
    public final function msg ($msg) {
        echo(is_array($msg) ? join(PHP_EOL, $msg) : $msg);
        ob_flush();
    }
    
    /**
     * 输出错误消息并退出
     * @param mixed $msg
     */
    public final function halt ($msg) {
        echo("error : " . (is_array($msg) ? join(PHP_EOL, $msg) : $msg));
        ob_flush();
        exit(1);
    }
    
    /**
     * 打印帮助信息
     */
    public final function help () {
        $this->msg($this->help);
        exit(0);
    }
    
    /**
     * 创建目录
     * @param unknown $dir
     */
    public function mkdir ($dir) {
        if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
            $this->halt("failed to create directory ({$dir})");
        }
    }
    
    /**
     * 写入文件
     * @param string $file
     * @param string $content
     */
    public function write_file ($file, $content) {
        if (!file_put_contents($file, $content, LOCK_EX)) {
            $this->halt('failed to write file ({$file})');
        }
    }

    /**
     * 获取相对路径
     * @param string $from
     * @param string $to
     * @param string $ds
     * @return string
     */
    public static function get_relpath ($from, $to, $ds = DIRECTORY_SEPARATOR) {
        $from_list = explode($ds, rtrim($from, $ds));
        $to_list   = explode($ds, rtrim($to, $ds));
        while (count($from_list) && count($to_list) && ($from_list[0] == $to_list[0])) {
            array_shift($from_list);
            array_shift($to_list);
        }
        return str_pad('', count($from_list) * 3, '..' . $ds) . implode($ds, $to_list);
    }

    /**
     * 执行
     */
    public function run () {
        // change work dir
        $cmd = $this->get_param(0);
        if (in_array($cmd, ['app', 'table'])) {
            $cls = "{$cmd}_build";
            $obj = new $cls();
            if ($this->has_param('help')) {
                $obj->help();
            }
            else {
                $this->msg([
                    "",
                    "", 
                    "current working path : " . __DIR__, 
                    "",
                    ""
                ]);
                $obj->run();
            }
        }
        else {
            $this->help();
        }
    }
}

/**
 * App 构建类
 * @author reginx
 */
class app_build extends build {
    
    /**
     * 帮助信息
     * @var array
     */
    public $help = [
        "",
        "Usage: php build.php app --id=user --name=default --prefix=/apps/foo ",
        "",
        "command options: ",
        "    --id             application id",
        "    --prefix         application directory",
        "    --name           application name",
        "    --data-dir       application data directory ",
        "    --inc-dir        application include directory",
        "    --static-dir     application static resource directory",
        "",
        "",
    ];
    
    /**
     * 执行
     * {@inheritDoc}
     * @see build::run()
     */
    public function run () {
        $app_config = [
            'id'        => $this->get_input("please enter the application ID", 
                $this->get_param('id') ?: 'default'),
            'name'      => $this->get_input("please enter the application name", 
                $this->get_param('name') ?: 'www'),
        ];

        // app path
        $app_config['prefix'] = $this->get_param('prefix');
        if (preg_match('/^[\.a-z0-9]/', $app_config['prefix'])) {
            $app_config['prefix'] = $this->dist_dir . '/' . $app_config['prefix'];
        }

        if (!$app_config['prefix']) {
            $app_config['prefix'] = $this->get_input("please enter the application installation path", 
                $this->dist_dir
            );
        }

        if (empty($app_config['prefix'])) {
            $this->halt('invalid application installation path');
        }

        if (!is_dir($app_config['prefix'])) {
            $this->mkdir($app_config['prefix']);
        }
        $app_config['prefix'] = realpath($app_config['prefix']);

        // data dir
        $app_config['data-dir'] = $this->get_input("please enter the application data directory",
            $this->get_param('data-dir') ?:
            ($app_config['prefix'] . DIRECTORY_SEPARATOR ."data"));
        if (!is_dir($app_config['data-dir'])) {
            $this->mkdir($app_config['data-dir']);
        }
        $app_config['data-dir'] = realpath($app_config['data-dir']);
        foreach (['attachment', 'cache', 'temp', 'log'] as $item) {
            $this->mkdir($app_config['data-dir'] . DIRECTORY_SEPARATOR . $item);
        }
        
        // static dir
        $app_config['static-dir'] = $this->get_input("please enter the application static resource directory",
            $this->get_param('static-dir') ?:
            ($app_config['prefix'] . DIRECTORY_SEPARATOR ."static"));
        if (!is_dir($app_config['static-dir'])) {
            $this->mkdir($app_config['static-dir']);
        }
        $app_config['static-dir'] = realpath($app_config['static-dir']);
        foreach (['fonts', 'images', 'style', 'js'] as $item) {
            $this->mkdir($app_config['static-dir'] . DIRECTORY_SEPARATOR . $item);
        }

        // include dir
        $app_config['inc-dir'] = $this->get_input("please enter the application data directory",
            $this->get_param('inc-dir') ?: 
            ($app_config['prefix'] . DIRECTORY_SEPARATOR . "include"));
        if (!is_dir($app_config['inc-dir'])) {
            $this->mkdir($app_config['inc-dir']);
        }
        $app_config['inc-dir'] = realpath($app_config['inc-dir']);
        foreach (['table', 'phar', 'helper'] as $item) {
            $this->mkdir($app_config['inc-dir'] . DIRECTORY_SEPARATOR . $item);
        }

        // create dir
        foreach (['config', 'module', 'lang', 'template/default'] as $item) {
            $this->mkdir($app_config['prefix'] . DIRECTORY_SEPARATOR . $item);
        }

        // create entry file
        $this->create_entry($app_config);
        $this->msg([
            "", 
            "Success !",
            "",
            "application directory : {$app_config['prefix']}",
            "", ""
        ]);
    }
    
    /**
     * 创建入口文件
     * @param array $app
     * @return boolean
     */
    public function create_entry ($app = []) {
        $rel_rgx_path = $this->get_relpath($app['prefix'], $this->src_dir);
        $rel_inc_path = $this->get_relpath($app['prefix'], $app['inc-dir']);
        $rel_data_path = $this->get_relpath($app['prefix'], $app['data-dir']);
        $tpl = [
            "<?php",
            "/*",
            "  +----------------------------------------------------------------------",
            "  + {$app['name']} app entry file",
            "  + ---------------------------------------------------------------------",
            "  + @date      " . date('Y-m-d H:i:s', time()),
            "  + @generator RGX v{$this->version_code}.{$this->version_name}",
            "  + @cmd       {$this->get_cmd()}",
            "  +----------------------------------------------------------------------",
            "*/",
            "define('IN_RGX', true);",
            "", "// app run mode, value is debug, normal, full",
            "define('RUN_MODE', 'debug');",
            "", "// app version",
            "define('APP_VER', '1.0.0');",
            "", "// abbr",
            "define('DS', DIRECTORY_SEPARATOR);",
            "", "// app ID",
            "define('APP_ID', '{$app['id']}');",
            "", "// app name",
            "define('APP_NAME', '{$app['name']}');",
            "", "// app root path",
            "define('APP_PATH', realpath('./') . DS);",
            "", "// includes table models, helper classes, phar and other files",
            "define('INC_PATH', realpath('{$rel_inc_path}') . DS);",
            "", "// includes runtime, template cache, data cache, attachments and other files",
            "define('DATA_PATH', realpath('{$rel_data_path}') . DS);",
            "", "// app namespace",
            "define('NS', 'com\\\\{$app['name']}_{$app['id']}');",
            "", "// load bootstrap file",
            "include('{$rel_rgx_path}/rgx.php');"
        ];
        $this->write_file(
            $app['prefix'] . DIRECTORY_SEPARATOR . "index.php", 
            join($this->eol, $tpl)
        );
        
        // index module
        $tpl = [
            "<?php",
            "namespace com\\{$app['name']}_{$app['id']};",
            "use \\re\\rgx as R;",
            "",
            "class index_module extends R\\module {",
            "",
            "    public function index_action () {",
            "        \$this->display('index.tpl');",
            "    }",
            "",
            "}",
        ];
        $this->write_file(
            join(DIRECTORY_SEPARATOR, [$app['prefix'], 'module', 'index.module.php']), 
            join($this->eol, $tpl)
        );
        
        // index tpl file
        $tpl = [
            "<!doctype html>",
            "<html>",
            "   <head>",
            "   <title>hello - RGX</title>",
            "   <meta charset=\"utf-8\"/>",
            "   </head>",
            "",
            "   <body>",
            "       <h1>Hello world ...</h1>",
            "   </body>",
            "</html>"
        ];
        $this->write_file(
            join(DIRECTORY_SEPARATOR, [$app['prefix'], 'template', 'default', 'index.tpl.html']), 
            join($this->eol, $tpl)
        );
        
        $tpl = [
            "<?php",
            "// http://dev.rgx.re/wiki/config.html",
            "// @see rgx/class/config.class.php",
            "return [",
            "    'db' => [",
            "        'pre'       => 'pre_',",
            "        'type'      => 'mysql',",
            "        'mysql'     => [",
            "            'default' => 'host=127.0.0.1;port=3306;db=helo;user=root;passwd=;charset=utf8mb4;profiling=1',",
            "        ],",
            "   ],",
            "];"
        ];
        $this->write_file(
            join(DIRECTORY_SEPARATOR, [$app['prefix'], 'config', 'config.php']),
            join($this->eol, $tpl)
        );
    }
}

/**
 * 表模型构建类
 * @author reginx
 */
class table_build extends build {

    /**
     * 帮助信息
     * @var array
     */
    public $help = [
        "",
        "Usage: php build.php table --prefix=/data/foo --all --force",
        "",
        "command options: ",
        "    --prefix         application installation path",
        "    --name           table name expression",
        "    --all            all table (false)",
        "    --allow-empty    allow fields to be empty (false)",
        "    --allow-null     allow fields to be null (false)",
        "    --force          forced overwrite (false)",
        "",
        "",
    ];

    /**
     * PDO 操作对象
     * @var \pdo
     */
    public $pdo = null;
    
    /**
     * 执行
     * {@inheritDoc}
     * @see build::run()
     */
    public function run () {
        if (!class_exists('PDO')) {
            $this->halt('extension PDO not found');
        }
        
        $app_config = [
            'force'         => $this->has_param('force'),
            'allow-empty'   => $this->has_param('allow-empty'),
            'allow-null'    => $this->has_param('allow-null')
        ];
        if ($this->has_param('all')) {
            unset($this->argv['name']);
        }
        else {
            $app_config['name'] = $this->get_input("please enter the table name expression",
                $this->get_param('name'));
        }
        
        // app path
        $app_config['prefix'] = $this->get_param('prefix');
        if (preg_match('/^[\.a-z0-9]/', $app_config['prefix'])) {
            $app_config['prefix'] = $this->dist_dir . '/' . $app_config['prefix'];
        }

        if (!$app_config['prefix']) {
            $app_config['prefix'] = $this->get_input("please enter the application installation path", 
                $this->dist_dir
            );
        }

        if (empty($app_config['prefix'])) {
            $this->halt('invalid application installation path');
        }

        if (!is_dir($app_config['prefix'])) {
            $this->halt('invalid application installation path');
        }
        $app_config['prefix'] = realpath($app_config['prefix']);
        
        var_dump($app_config);
        $entry_file = $app_config['prefix'] . "/index.php";
        if (!file_exists($entry_file)) {
            $this->halt("entry file not found {$entry_file}");
        }
        $defines = file_get_contents($entry_file);
        if (empty($defines)) {
            $this->halt('invalid entry file {$entry_file}');
        }
        
        $matches = [];
        preg_match_all('/\s*define\(\'(NS|INC_PATH)\',\s*\'?(.+?)\'?\);/is', $defines, $matches);
        if (count($matches[1]) != 2) {
            $this->halt('invalid entry file');
        }
        foreach ((array)$matches[2] as $v) {
            if (strpos($v, 'realpath') === 0) {
                $app_config['inc-dir'] = realpath($app_config['prefix'] . DIRECTORY_SEPARATOR . 
                                            preg_replace('/(realpath\(\')|(\'\)\s*\.\s*DS)/is', '', $v));
            }
            if (strpos($v, 'com') === 0) {
                $app_config['namespace'] = $v;
            }
        }
        if (empty($app_config['inc-dir'])) {
            $this->halt("failed to get the include path");
        }
        
        if (empty($app_config['namespace'])) {
            $this->halt("failed to get namespace");
        }
        $this->msg(PHP_EOL . "application info" . PHP_EOL);
        $this->msg("application path          : {$app_config['prefix']}"    . PHP_EOL);
        $this->msg("application include path  : {$app_config['inc-dir']}"   . PHP_EOL);
        $this->msg("application namespace     : {$app_config['namespace']}" . PHP_EOL);
        $this->msg(PHP_EOL);
        
        $config_file = "{$app_config['prefix']}/config/config.php";
        if (!file_exists($config_file)) {
            $this->halt("application config file not found ({$config_file})");
        }
        
        $config = include($config_file);
        if (!isset($config['db'][$config['db']['type']]['default'])) {
            $this->halt('DSN is empty' . PHP_EOL);
        }
        if ($config['db']['type'] != 'mysql') {
            $this->halt("{$config['db']['type']} does not support" . PHP_EOL);
        }
        $dsn = $config['db'][$config['db']['type']]['default'];
        parse_str(join('&', explode(';', $dsn)), $dsn);
        
        $prefix = $config['db']['pre'];
        $app_config['db_pre'] = $prefix;

        $dsn['db'] = $dsn['db'] ?: null;
        $dsn['host'] = $dsn['host'] ?: '127.0.0.1';
        $dsn['user'] = $dsn['user'] ?: 'root';
        $dsn['port'] = $dsn['port'] ?: 3306;
        $dsn['passwd'] = $dsn['passwd'] ?: '';
        $dsn['charset'] = $dsn['charset'] ?: 'utf8';
        $db_type = strtoupper($config['db']['type']);

        $this->msg("{$db_type} info" . PHP_EOL);
        $this->msg("{$db_type} database host       : {$dsn['host']}"    . PHP_EOL);
        $this->msg("{$db_type} database name       : {$dsn['db']}"      . PHP_EOL);
        $this->msg("{$db_type} database account    : {$dsn['user']}"    . PHP_EOL);
        $this->msg("{$db_type} database passwd     : {$dsn['passwd']}"  . PHP_EOL);
        $this->msg("{$db_type} database port       : {$dsn['port']}"    . PHP_EOL);
        $this->msg("{$db_type} database charset    : {$dsn['charset']}" . PHP_EOL);
        $this->msg("{$db_type} table name prefix   : {$prefix}"         . PHP_EOL);
        $this->msg(PHP_EOL);

        try {
            $this->pdo = new PDO("mysql:host={$dsn['host']};port={$dsn['port']}", $dsn['user'], $dsn['passwd']);
        }
        catch (Exception $e) {
            $this->halt($e->getMessage());
        }

        if ($this->pdo->exec("use {$dsn['db']}") === false) {
            $this->halt("database not exists {$dsn['db']}");
        }

        $this->pdo->exec("set names {$dsn['charset']}");

        $tables = [];
        if (isset($app_config['name']) && $app_config['name']) {
            // user,user_info
            if (preg_match('/[\w\*]+(\,[\w\*]+)*/i', $app_config['name'])) {
                $tables = array_map(function ($name) use ($prefix) {
                    return "/^" . preg_quote($prefix) . str_replace('\\*', '\w*', preg_quote($name)) . "$/i";
                }, explode(',', $app_config['name']));
            }
        }

        // query
        foreach ($this->pdo->query("show tables like '{$prefix}%'", PDO::FETCH_COLUMN, 0) as $table_name) {
            $generate = empty($tables);
            // 存在匹配条件, 判断是否需要生成
            foreach ((array)$tables as $regex) {
                if (preg_match($regex, $table_name)) {
                    $generate = true;
                    break;
                }
                else {
                    $generate = $regex == $table_name;
                }
            }

            if ($generate) {
                $this->generate_table_file($table_name, $app_config);
            }
        }

    }

    /**
     * 生成表模型文件
     * @param string $table_name
     * @param array $config
     * @return boolean
     */
    public function generate_table_file ($table_name, $config) {
        $tab_name = preg_replace('/^' . preg_quote($config['db_pre']) . '/', '', $table_name);
        $tab_path = str_replace('_', DIRECTORY_SEPARATOR, $tab_name);
        $tab_file = $config['inc-dir'] . DIRECTORY_SEPARATOR . "table" . DIRECTORY_SEPARATOR . "{$tab_path}.table.php";

        $this->msg([
            "",
            "generate " . $tab_path . ".table.php",
            "",
        ]);
        $info = $this->get_info($table_name);

        $table_tpl = join($this->eol, [
            "<?php",
            "namespace re\\rgx;",
            "",
            "/*",
            "  +-----------------------------------------------------------------",
            "  + {$info['table_name']} 表模型",
            "  + ----------------------------------------------------------------",
            "  + @date " . date('Y-m-d H:i:s', time()),
            "  + @desc 若修改了表结构, 请使用下面的命令更新模型文件",
            "  + @cmd  {$this->get_cmd()}",
            "  + @generator RGX v{$this->version_code}.{$this->version_name}",
            "  +-----------------------------------------------------------------",
            "*/",
            "class {$tab_name}_table extends table {",
            "",
            "    /*",
            "      +--------------------------",
            "      + 编码",
            "      +--------------------------",
            "    */",
            "    protected \$_charset = '-*-charset-*-';",
            "",
            "    /*",
            "      +--------------------------",
            "      + 字段",
            "      +--------------------------",
            "    */",
            "    protected \$_fields = [",
            "        -*-fields-*-",
            "    ];",
            "",
            "    /*",
            "      +--------------------------",
            "      + 主键",
            "      +--------------------------",
            "    */",
            "    protected \$_primary_key = [",
            "        -*-primary_key-*-",
            "    ];",
            "",
            "    /*",
            "      +--------------------------",
            "      + 字段默认值",
            "      +--------------------------",
            "    */",
            "    public \$defaults = [",
            "        -*-defaults-*-",
            "    ];",
            "",
            "    /*",
            "      +--------------------------",
            "      + 字段过滤规则",
            "      +--------------------------",
            "    */",
            "    public \$filter = [",
            "        -*-filter-*-",
            "    ];",
            "",
            "    /*",
            "      +--------------------------",
            "      + 唯一性检测",
            "      +--------------------------",
            "    */",
            "    public \$unique_check = [",
            "        -*-unique_check-*-",
            "    ];",
            "",
            "    /*",
            "      +--------------------------",
            "      + 自定义字段验证规则",
            "      +--------------------------",
            "    */",
            "    public \$validate = [];",
            "",
            "}",
        ]);

        // 非强制更新且文件存在
        if (!$config['force'] && file_exists($tab_file)) {
            $this->msg([
                "",
                $tab_file,
                "already exists"
            ]);
            $cmd = strtoupper($this->get_input("does it overwrite? [Y/N/Q]", 'Y'));
            // quit
            if ($cmd == 'Q') {
                $this->msg([
                    "",
                    "bye",
                    "",
                    ""
                ]);
                exit(0);
            }
            // skip
            else if ($cmd != 'Y') {
                $this->msg("@skip {$tab_path}.table.php" . PHP_EOL . PHP_EOL);
                return false;
            }
            // overwrite
            else {
                $this->msg("@update {$tab_file}" . PHP_EOL);

                // 更新文件内容
                $table_tpl = file_get_contents($tab_file);
                // reset
                $table_tpl = preg_replace('/protected \$_charset = \'[^;]+?\';/is',
                        "protected \$_charset = '-*-charset-*-';", $table_tpl);
                $table_tpl = preg_replace('/protected \$_fields = \[[^;]+?\];/is',
                        "protected \$_fields = [{$this->eol}        -*-fields-*-{$this->eol}    ];", $table_tpl);
                $table_tpl = preg_replace('/protected \$_primary_key = \[[^;]+?\];/is',
                        "protected \$_primary_key = [{$this->eol}        -*-primary_key-*-{$this->eol}    ];", $table_tpl);
                $table_tpl = preg_replace('/public \$defaults = \[[^;]+?\];/is',
                        "public \$defaults = [{$this->eol}        -*-defaults-*-{$this->eol}    ];", $table_tpl);
                $table_tpl = preg_replace('/public \$filter = \[[^;]+?\];/is',
                        "public \$filter = [{$this->eol}        -*-filter-*-{$this->eol}    ];", $table_tpl);
                $table_tpl = preg_replace('/public \$unique_check = \[[^;]+?\];/is',
                        "public \$unique_check = [{$this->eol}        -*-unique_check-*-{$this->eol}    ];", $table_tpl);
                $table_tpl = preg_replace('/@cmd (.+?)\n/is', "@cmd  {$this->get_cmd()}" . PHP_EOL, $table_tpl);
                $table_tpl = preg_replace('/@update (.+?)\n/is', "@update " . date('Y-m-d H:i:s', time()) . PHP_EOL, $table_tpl);
            }
        }

        // 创建目录
        if (!is_dir(dirname($tab_file))) {
            $this->mkdir(dirname($tab_file));
        }

        $fields = $defaults = $validate = $filter = $primary_key = [];

        // charset
        $table_tpl = str_replace('-*-charset-*-', $info['charset'], $table_tpl);

        $res = $this->pdo->query("show full fields from {$table_name}");
        $field_list = [];
        $field_max_len = 0;
        $tmp_pk = [];
        $tmp_incr = 'false';
        while (($row = $res->fetch(PDO::FETCH_ASSOC)) != false) {
            $field_list[$row['Field']] = $row;
            $field_max_len = $field_max_len < strlen($row['Field']) ? strlen($row['Field']) : $field_max_len;
            if ($row['Key'] == 'PRI') {
                $tmp_incr = $row['Extra'] == 'auto_increment' ? 'true' : 'false';
                $tmp_pk[] = $row['Field'];
            }
        }

        if (count($tmp_pk) == 1) {
            $primary_key[] = "'key' => '{$tmp_pk[0]}',";
            $primary_key[] = "'inc' => {$tmp_incr}";
        }
        else if (count($tmp_pk) > 1) {
            $primary_key[] = "'key' => ['" . join("', '", $tmp_pk) . "'],";
            $primary_key[] = "'inc' => false";
        }
        else {
            $primary_key[] = "'key' => '',";
            $primary_key[] = "'inc' => false,";
        }


        foreach ($field_list as $row) {
            $space_append = str_repeat(' ', ceil($field_max_len / 4) * 4 - strlen($row['Field']));
            $field = mysql_extra::get_field_default($row);
            if (!isset($field['null'])) {
                var_dump($field, 333);
            }
            $fields_attrs = ['['];
            $fields_attrs[] = "            'name'               => '{$field['field']}',";
            $fields_attrs[] = "            'type'               => '{$field['class']}',";
            $fields_attrs[] = "            'field_type'         => '{$field['type']}',";
            $fields_attrs[] = "            'min'                => {$field['min']},";
            $fields_attrs[] = "            'max'                => {$field['max']},";
            $fields_attrs[] = "            'label'              => '{$field['label']}',";

            $filter_method  = $field['class'];
            if ($field['class'] == 'int' || $field['class'] == 'float') {
                $defaults[] = "'{$field['field']}'{$space_append}=> {$field['default']},";
            }
            else if ($field['class'] == 'char') {
                $defaults[] = "'{$field['field']}'{$space_append}=> '{$field['default']}',";
            }
            else if ($field['class'] == 'date') {
                $defaults[] = "'{$field['field']}'{$space_append}=> '{$field['default']}',";
                $fields_attrs[] = "            'validate'           => {$field['validate']},";
                $filter_method = null;
            }
            else if ($field['class'] == 'set') {
                $defaults[] = "'{$field['field']}'{$space_append}=> '{$field['default']}',";
                $fields_attrs[] = "            'options'        => {$field['options']},";
                $filter_method = null;
            }

            if (!empty($filter_method)) {
                $filter[]   = "'{$field['field']}'{$space_append}=> ['re\\rgx\\filter', '{$filter_method}'],";
            }

            $fields_attrs[] = "            'allow_empty_string' => " . ($config['allow-empty'] ? 'true' : 'false') . ",";
            $fields_attrs[] = "            'allow_null'         => " . ($config['allow-null']  ? 'true' : 'false');
            $fields_attrs[] = "        ]";
            $fields_attrs = join($this->eol, $fields_attrs);
            $fields[] = "'{$row['Field']}' => {$fields_attrs},";
        }

        $output = str_replace('-*-defaults-*-', join($this->eol . "        ", $defaults), $table_tpl);
        $output = str_replace('-*-filter-*-', join($this->eol . "        ", $filter), $output);
        $output = str_replace('-*-validate-*-', '[]', $output);
        $output = str_replace('-*-fields-*-', join($this->eol . "        ", $fields), $output);
        $output = str_replace('-*-primary_key-*-', join($this->eol . "        ", $primary_key), $output);

        // unique check
        $index_query = $this->pdo->query("show index from {$table_name}");
        $unique_check = [];
        while (($row = $index_query->fetch(PDO::FETCH_ASSOC)) != false) {
            if (!$row['Non_unique']) {
                if (($row['Column_name'] != $tmp_pk[0]) || count($tmp_pk) > 1) {
                    $unique_check[$row['Key_name']][] = $row['Column_name'];
                }
                else if (!$tmp_incr) {
                    $unique_check[$row['Key_name']][] = $row['Column_name'];
                }
                else {
                    $this->msg("@@@ unique check skip auto_increment field `{$table_name}`.`{$row['Column_name']}`" . PHP_EOL);
                }
            }
        }
        if (!empty($unique_check)) {
            $unique_check = array_map(function ($keys) {
                return '[\'' . join('\', \'', $keys) . '\']';
            }, $unique_check);
        }
        $output = str_replace('-*-unique_check-*-', join("," . $this->eol . "        ", $unique_check), $output);
        $this->write_file($tab_file, $output);
        $this->msg("create table file {$tab_name}_table success ..." . PHP_EOL);
    }

    /**
     * 获取表信息
     * @param unknown $table_name
     * @return string|mixed
     */
    public function get_info ($table_name) {
        $ret = [
            'charset'       => 'utf8',
            'table_name'    => $table_name
        ];
        $match = [];
        $tab_sql = $this->pdo->query("show create table {$table_name}")->fetch(PDO::FETCH_ASSOC)['Create Table'];
        preg_match('/CHARSET=(\w+)/i', $tab_sql, $match);
        $ret['charset'] = isset($match[1]) ? $match[1] : $ret['charset'];

        preg_match('/comment=\'(.+?)\'/i', $tab_sql, $match);
        $ret['table_name'] = isset($match[1]) ? $match[1] : $ret['table_name'];
        
        return $ret;
    }
}

/**
 * MySQL 表模型处理类
 * @author reginx
 */
class mysql_extra {
    
    /**
     * 字段类型验证规则
     * @var array
     */
    private static $_validate = [
        'tinyint'   => [
            'byte'      => 1,
            'signed'    => [-128, 127],
            'unsigned'  => [0, 255],
        ],
        'smallint'  => [
            'byte'      => 2,
            'signed'    => [-32768, 32767],
            'unsigned'  => [0, 65535],
        ],
        'mediumint' => [
            'byte'      => 3,
            'signed'    => [-8388608, 8388607],
            'unsigned'  => [0, 16777215],
        ],
        'int'       => [
            'byte'      => 4,
            'signed'    => [-2147483648, 2147483647],
            'unsigned'  => [0, 4294967295],
        ],
        'bigint'    => [
            'byte'      => 8,
            'signed'    => [-9223372036854775808, 9223372036854775807],
            'unsigned'  => [0, 18446744073709551615],
        ],
        'serial'    => [
            'byte'      => 8,
            'signed'    => [-9223372036854775808, 9223372036854775807],
            'unsigned'  => [0, 18446744073709551615],
        ],
        'decimal'   => [
            'byte'      => 0,
            'signed'    => [66, 30],
            'unsigned'  => [65, 30],
        ],
        'float'     => [
            'byte'      => 4,
            'signed'    => [64, 30],
            'unsigned'  => [64, 30],
        ],
        'bit'       => [
            'range'     => [1, 64]
        ],
        'boolean'       => [
            'range'     => [0, 1]
        ],
        'char'          => [
            'range'     => [0, 255]
        ],
        'varchar'       => [
            'range'     => [0, 65536]
        ],
        'tinytext'      => [
            'range'     => [0, 255]
        ],
        'text'          => [
            'range'     => [0, 65535]
        ],
        'mediumtext'    => [
            'range'     => [0, 16777215]
        ],
        'longtext'      => [
            'range'     => [0, 4294967295]
        ],
        'tinyblob'      => [
            'range'     => [0, 255]
        ],
        'blob'          => [
            'range'     => [0, 65535]
        ],
        'mediumblob'    => [
            'range'     => [0, 16777215]
        ],
        'longblob'      => [
            'range'     => [0, 4294967295]
        ],
        'date'          => [
            'year'      => "['re\\rgx\\filter', 'is_mysql_year']",
            'date'      => "['re\\rgx\\filter', 'is_mysql_date']",
            'datetime'  => "['re\\rgx\\filter', 'is_mysql_datetime']",
            'timestamp' => "['re\\rgx\\filter', 'is_mysql_timestamp']",
            'time'      => "['re\\rgx\\filter', 'is_mysql_time']"
        ]
    ];
    
    /**
     * 字段类型
     * @var array
     */
    private static $_types = [
        'bit|bool|boolean'                                  => 'bit',
        'decimal|float|double|real'                         => 'float',
        'tinyint|smallint|mediumint|int|bigint|serial'      => 'int',
        'char|varchar|tinytext|text|mediumtext|longtext'    => 'char',
        'blob|varblob|tinyblob|blob|mediumblob|longblob'    => 'blob',
        'date|datetime|time|timestamp|year'                 => 'date',
        'set|enum'                                          => 'set',
    ];
    
    /**
     * 获取字段信息
     * @param unknown $row
     * @return number[]|string[]|unknown[]|boolean[]|mixed[]|NULL[]
     */
    public static function get_field_default ($row) {
        $ret = [
            'field' => $row['Field'],
            'field_length'  => count($row['Field'])
        ];
        foreach (self::$_types as $k => $v) {
            $m = [];
            preg_match("/^({$k}).*?(\(.*\))?/is", $row['Type'], $m);
            if (isset($m[1]) && !empty($m[1])) {
                $ret['type'] = $m[1];
                $ret['null'] = $row['Null'] == 'NO' ? false : true;
                $ret['label'] = $row['Comment'] ?: $row['Field'];
                $ret['label'] = preg_replace('/\(.+\)/is', '', $ret['label']);
                $us = strpos($row['Type'], 'unsigned') !== false;
                
                if ($v == 'int') {
                    $ret['class'] = 'int';
                    $ret['default'] = $row['Default'] ?: 0;
                    $range = self::$_validate[$m[1]][$us ? 'unsigned' : 'signed'];
                    if (isset($m[2])) {
                        $max = (int)str_replace(['(', ')'], '', $m[2]);
                        $max = (int)str_repeat(9, $max);
                        $min = $us ? 0 : (0 - $max);
                        $ret['min'] = $min < $range[0] ? $range[0] : $min;
                        $ret['max'] = $max > $range[1] ? $range[1] : $max;
                        $ret['min'] = $range[0];// : $min;
                        $ret['max'] = $range[1];// : $max;
                        
                    }
                    else {
                        $ret['min'] = $range[0];
                        $ret['max'] = $range[1];
                    }
                }
                else if ($v == 'float') {
                    $ret['class'] = 'float';
                    $ret['default'] = $row['Default'] ?: 0;
                    if (isset($m[2])) {
                        list($ret['min'], $ret['max']) = explode(',', str_replace(['(', ')'], '', $m[2]));
                    }
                    // 取默认值
                    else {
                        $range = self::$_validate[$m[1]][$us ? 'unsigned' : 'signed'];
                        $ret['min'] = $range[0];
                        $ret['max'] = $range[1];
                    }
                }
                else if ($v == 'char') {
                    $ret['class'] = 'char';
                    $ret['default'] = $row['Default'] ?: '';
                    if (!isset($m[2])) {
                        $range = self::$_validate[$m[1]]['range'];
                        $ret['min'] = $range[0];
                        $ret['max'] = $range[1];
                    }
                    else {
                        $ret['min'] = 0;
                        $ret['max'] = str_replace(['(', ')'], '', $m[2]);
                    }
                }
                else if ($v == 'date') {
                    $ret['class'] = 'date';
                    $ret['min'] = 0;
                    $ret['max'] = 0;
                    $ret['default'] = $row['Default'] ?: '';
                    $ret['validate'] = self::$_validate['date'][$m[1]];
                }
                else if ($v == 'set' || $v == 'enum') {
                    $ret['class'] = 'set';
                    $ret['min'] = 0;
                    $ret['max'] = 0;
                    $ret['default'] = $row['Default'] ?: '';
                    $ret['options'] = str_replace(['(', ')'], ['[', ']'], $m[2]);
                }
                
                break;
            }
        }
        return $ret;
    }
}

error_reporting(E_ALL ^ E_NOTICE);
chdir(__DIR__);
date_default_timezone_set('PRC');

(new build())->run();

