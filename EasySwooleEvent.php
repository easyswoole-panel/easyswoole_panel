<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;


use App\IpList;
use Co\Server;
use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Component\Process\Exception;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\FastCache\Cache;
use EasySwoole\FastCache\Exception\RuntimeError;
use EasySwoole\Http\Message\Status;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\FastCache\CacheProcessConfig;
use EasySwoole\FastCache\SyncData;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\DbManager;
use EasySwoole\Utility\File;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
        $configData = Config::getInstance()->getConf('MYSQL');
        $config = new \EasySwoole\ORM\Db\Config($configData);
        DbManager::getInstance()->addConnection(new Connection($config));
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.

        // // 开启IP限流
        // IpList::getInstance();
        // $class = new class('IpAccessCount') extends AbstractProcess{
        //     protected function run($arg)
        //     {
        //         $this->addTick(5*1000, function (){
        //             /**
        //              * 正常用户不会有一秒超过6次的api请求
        //              * 做列表记录并清空
        //              */
        //             $list = IpList::getInstance()->accessList(30);
        //             IpList::getInstance()->clear();
        //         });
        //     }
        // };
        // ServerManager::getInstance()->getSwooleServer()->addProcess($class->getProcess());


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
        // IP限流
        // $fd = $request->getSwooleRequest()->fd;
        // $ip = ServerManager::getInstance()->getSwooleServer()->getClientInfo($fd)['remote_ip'];
        // if (IpList::getInstance()->access($ip) > 3) {
        //     /**
        //      * 直接强制关闭连接
        //      */
        //     ServerManager::getInstance()->getSwooleServer()->close($fd);
        //     echo '被拦截'.PHP_EOL;
        //     return false;
        // }

        $allow_origin = array(
            "http://easyswoole.test"
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