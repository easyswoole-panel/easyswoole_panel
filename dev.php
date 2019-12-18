<?php
/**
 * Created by PhpStorm.
 * Users: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

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
            'max_wait_time'=>3
        ],
	'TASK' => [
	    'workerNum' => 4,
	    'maxRunningNum' => 128,
	    'timeout' => 15,
	]
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,
    'PHAR' => [
        'EXCLUDE' => ['.idea', 'Log', 'Temp', 'easyswoole', 'easyswoole.install']
    ],
    // 'MYSQL' => [
    //     //数据库配置
    //     'host'                 => '192.168.254.1',//数据库连接ip
    //     'user'                 => 'root',//数据库用户名
    //     'password'             => 'root',//数据库密码
    //     'database'             => 'siam_admin',//数据库
    //     'port'                 => '3306',//端口
    //     'timeout'              => '30',//超时时间
    //     'connect_timeout'      => '5',//连接超时时间
    //     'charset'              => 'utf8',//字符编码
    //     'strict_type'          => false, //开启严格模式，返回的字段将自动转为数字类型
    //     'fetch_mode'           => false,//开启fetch模式, 可与pdo一样使用fetch/fetchAll逐行或获取全部结果集(4.0版本以上)
    //     'alias'                => '',//子查询别名
    //     'isSubQuery'           => false,//是否为子查询
    //     'max_reconnect_times ' => '3',//最大重连次数
    // ],
    'MYSQL' => [
        //数据库配置
        'host'                 => '127.0.0.1',//数据库连接ip
        'user'                 => 'root',//数据库用户名
        'password'             => 'root',//数据库密码
        'database'             => 'admin',//数据库
        'port'                 => '3306',//端口
        'timeout'              => '30',//超时时间
        'connect_timeout'      => '5',//连接超时时间
        'charset'              => 'utf8',//字符编码
        'strict_type'          => false, //开启严格模式，返回的字段将自动转为数字类型
        'fetch_mode'           => false,//开启fetch模式, 可与pdo一样使用fetch/fetchAll逐行或获取全部结果集(4.0版本以上)
        'alias'                => '',//子查询别名
        'isSubQuery'           => false,//是否为子查询
        'max_reconnect_times ' => '3',//最大重连次数
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
