<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use EasySwoole\Component\Process\Exception;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\FastCache\Cache;
use EasySwoole\FastCache\Exception\RuntimeError;
use EasySwoole\Http\Message\Status;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\MysqliPool\MysqlPoolException;
use EasySwoole\FastCache\CacheProcessConfig;
use EasySwoole\FastCache\SyncData;
use EasySwoole\Utility\File;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        $mysqlConfig = new \EasySwoole\Mysqli\Config(Config::getInstance()->getConf('MYSQL'));
        try {
            \EasySwoole\MysqliPool\Mysql::getInstance()->register('mysql', $mysqlConfig);
        } catch (MysqlPoolException $e) {
            echo "[Warn] --> mysql池注册失败\n";
        }

        // ***************** 注册fast-cache *****************
        // 每隔5秒将数据存回文件
        try {
            Cache::getInstance()->setTickInterval(5 * 1000);//设置定时频率
            Cache::getInstance()->setOnTick(function (SyncData $SyncData, CacheProcessConfig $cacheProcessConfig) {
                $data = [
                    'data'  => $SyncData->getArray(),
                    'queue' => $SyncData->getQueueArray(),
                ];
                $path = EASYSWOOLE_TEMP_DIR.'/FastCacheData/'.$cacheProcessConfig->getProcessName();
                File::createFile($path, serialize($data));
            });
        } catch (RuntimeError $e) {
            echo "[Warn] --> fast-cache注册onTick失败\n";
        }

        // 启动时将存回的文件重新写入
        try {
            Cache::getInstance()->setOnStart(function (CacheProcessConfig $cacheProcessConfig) {
                $path = EASYSWOOLE_TEMP_DIR.'/FastCacheData/'.$cacheProcessConfig->getProcessName();
                if (is_file($path)) {
                    $data     = unserialize(file_get_contents($path));
                    $syncData = new SyncData();
                    $syncData->setArray($data['data']);
                    $syncData->setQueueArray($data['queue']);
                    return $syncData;
                }
            });
        } catch (RuntimeError $e) {
            echo "[Warn] --> fast-cache注册onStart失败\n";
        }

        // 在守护进程时,php easyswoole stop 时会调用,落地数据
        try {
            Cache::getInstance()->setOnShutdown(function (SyncData $SyncData, CacheProcessConfig $cacheProcessConfig) {
                $data = [
                    'data'  => $SyncData->getArray(),
                    'queue' => $SyncData->getQueueArray(),
                ];
                $path = EASYSWOOLE_TEMP_DIR.'/FastCacheData/'.$cacheProcessConfig->getProcessName();
                File::createFile($path, serialize($data));
            });
        } catch (RuntimeError $e) {
            echo "[Warn] --> fast-cache注册onShuatdown失败\n";
        }

        try {
            Cache::getInstance()->setTempDir(EASYSWOOLE_TEMP_DIR)
                ->setServerName("easySiam_fast_cache")
                ->setProcessNum(3)
                ->attachToServer(ServerManager::getInstance()->getSwooleServer());
        } catch (Exception $e) {
            echo "[Warn] --> fast-cache注册失败\n";
        } catch (RuntimeError $e) {
            echo "[Warn] --> fast-cache注册失败\n";
        }


    }

    public static function onRequest(Request $request, Response $response): bool
    {
        $allow_origin = array(
            'http://192.168.23.128',
        );

        $origin = $request->getHeader('origin');

        if ($origin !== []){
            $origin = $origin[0];
            if(in_array($origin, $allow_origin)){
                $response->withHeader('Access-Control-Allow-Origin', $origin);
                $response->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
                $response->withHeader('Access-Control-Allow-Credentials', 'true');
                $response->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, token');
                if ($request->getMethod() === 'OPTIONS') {
                    $response->withStatus(Status::CODE_OK);
                    return false;
                }
            }
        }

        $response->withHeader('Content-type', 'application/json;charset=utf-8');

        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}