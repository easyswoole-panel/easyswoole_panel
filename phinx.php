<?php

defined('SWOOLE_VERSION') or define('SWOOLE_VERSION', intval(phpversion('swoole')));
defined('EASYSWOOLE_ROOT') or define('EASYSWOOLE_ROOT', realpath(getcwd()));
defined('EASYSWOOLE_SERVER') or define('EASYSWOOLE_SERVER', 1);
defined('EASYSWOOLE_WEB_SERVER') or define('EASYSWOOLE_WEB_SERVER', 2);
defined('EASYSWOOLE_WEB_SOCKET_SERVER') or define('EASYSWOOLE_WEB_SOCKET_SERVER', 3);

$databaseConfig = require_once "./dev.php";
define('PHINX_PRE', $databaseConfig['MYSQL']['prefix']);

return
[
    'paths' => [
        'migrations' => EASYSWOOLE_ROOT.'/database/migrations',
        'seeds' => EASYSWOOLE_ROOT.'/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => PHINX_PRE.'migrate_logs',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $databaseConfig['MYSQL']['host'],
            'name' => $databaseConfig['MYSQL']['database'],
            'user' => $databaseConfig['MYSQL']['user'],
            'pass' => $databaseConfig['MYSQL']['password'],
            'port' => $databaseConfig['MYSQL']['port'],
            'charset' => $databaseConfig['MYSQL']['charset'],
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
