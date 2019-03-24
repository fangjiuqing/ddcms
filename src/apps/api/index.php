<?php
/*
  +-------------------------------------------------------
  + default App entry file
  + ------------------------------------------------------
  + @update 2017-07-19 11:42:55
  + @cmd /bin/php ./rgx/./build.php -c -d=../www -i=www -n=default -id=../include/
  +-------------------------------------------------------
*/
chdir(__DIR__);
define('IN_RGX',   true);
define('RUN_MODE', 'debug');
define('APP_VER', '1.0.0');
define('DS',       DIRECTORY_SEPARATOR);
define('NS',       'com\\default_api');
define('APP_ID',   'www');
define('APP_NAME', 'default');
define('APP_PATH', realpath('./') . DS);
define('INC_PATH', realpath('./include') . DS);
define('DATA_PATH', realpath('data') . DS);
include('../../rgx/rgx.php');