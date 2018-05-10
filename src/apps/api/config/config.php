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
        'image_url'     => 'http://p4r3lxyo0.bkt.clouddn.com/'
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
   ]
];
