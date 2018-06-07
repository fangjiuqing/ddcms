<?php
// http://dev.rgx.re/wiki/config.html
// @see rgx/class/config.class.php
return [

    // 数据库配置
    'db'      => [
        'pre'       => 'pre_',
        'type'      => 'mysql',
        'mysql'     => [
            'default' => 'host=188.server;port=3306;db=ddzz;user=root;passwd=123456;charset=utf8mb4;profiling=1',
        ],
   ],

   // 常量配置
   'defines'  => [
        'image_url'     => 'http://attachment.ddzz360.com/'
   ],

   // 消息队列配置
   'mq'       => [
        'pre'       => 'RMQ_',
        'type'      => 'redis',
        'redis'     => [
            'host'  => '188.server',
            'port'  => 6379,
            'db'    => 6
        ]
   ],

   'sess'     => [
        'type'      => 'redis',
        // 默认通过 cookie 传递 ( 可选 cookie, header)
        'via'       => 'header',
        // 默认实现
        'php'       => [
            'ttl'   => 1800,
        ],
        // Redis 实现
        'redis'     => [
            'host'  => '188.server',
            'port'  => 6379,
            'db'    => 5,
            'ttl'   => 1800
        ]
    ]
];
