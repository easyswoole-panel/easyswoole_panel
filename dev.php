<?php
return [
    'SERVER_NAME' => "easySiam",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,
            'reload_async' => true,
            'max_wait_time'=>3,
            'document_root' => './public', // 版本小于v4.4.0时必须为绝对路径
            'enable_static_handler' => true,
        ],
	'TASK' => [
	    'workerNum' => 1,
	    'maxRunningNum' => 128,
	    'timeout' => 1,
	]
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,
    'PHAR' => [
        'EXCLUDE' => ['.idea', 'Log', 'Temp', 'easyswoole', 'easyswoole.install']
    ],
    'MYSQL' => [
        //数据库配置
        'host'                 => '127.0.0.1',//数据库连接ip
        'user'                 => 'newadmin',//数据库用户名
        'password'             => 'RdkfmTScjJPpHx4k',//数据库密码
        'database'             => 'newadmin',//数据库
        'port'                 => '3306',//端口
        'timeout'              => '30',//超时时间
        'connect_timeout'      => '5',//连接超时时间
        'charset'              => 'utf8',//字符编码
        'max_reconnect_times ' => '3',//最大重连次数
        'prefix'               => 'siam_',
    ],
    /**##################     JWT      #############*/
    'JWT' => [
        'iss' => 'siam', // 发行人
        'exp' => 7200, // 过期时间 默认2小时 2*60*60=7200
        'sub' => 'easySiam', // 主题
        'nbf' => NULL, // 在此之前不可用
        'key' => 'www.siammmm.cn', // 签名用的key
    ],
];
