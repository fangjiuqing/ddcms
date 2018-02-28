<?php
// http://dev.rgx.re/wiki/config.html
// @see rgx/class/config.class.php
return [
    'db' => [
        'pre'       => 'pre_',
        'type'      => 'mysql',
        'mysql'     => [
            'default' => 'host=127.0.0.1;port=3306;db=helo;user=root;passwd=;charset=utf8mb4;profiling=1',
            'default' => 'host=10.1.1.188;port=3306;db=ddzz;user=root;passwd=123456;charset=utf8mb4;profiling=1',
        ],
   ],
];