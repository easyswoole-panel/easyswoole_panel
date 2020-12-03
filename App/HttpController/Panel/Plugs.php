<?php
/**
 * 面板内部接口 不建议修改
 * User: Siam
 * Date: 2020/12/1 0001
 * Time: 21:09
 */

namespace App\HttpController\Panel;

use EasySwoole\EasySwoole\Task\TaskManager;
use EasySwoole\Http\AbstractInterface\Controller;
use Siam\Plugs\service\PlugsAuthService;
use Siam\Plugs\service\PlugsInstallService;

class Plugs extends Controller
{
    /**
     * 扫描composer.json读取插件列表、是否已经安装
     */
    public function get_list()
    {
        $composerFile = file_get_contents(EASYSWOOLE_ROOT."/composer.json");
        $composerFile = json_decode($composerFile, TRUE);
        $vendorList   = $composerFile['require'];

        $return = [];
        foreach ($vendorList as $vendorName  => $vendorVersion){
            if (PlugsAuthService::isPlugs($vendorName)){
                $return[$vendorName] = PlugsAuthService::getPlugsConfig($vendorName);
                $return[$vendorName]['installed'] = PlugsInstallService::isInstalled($vendorName);
            }
        }

        $this->writeJson(200, $return);
    }

    /**
     * TODO 通过插件名 扫描运行包内的install逻辑
     */
    public function install()
    {
        $vendorName = "siam/adminTestPlugs";
        if (!PlugsAuthService::isPlugs($vendorName)){
            return $this->writeJson('500', [], '不是合法插件');
        }
        try{
            // todo 更新/全新安装
            PlugsInstallService::install($vendorName);
        }catch (\Throwable $e){
            return $this->writeJson('500', [], $e->getMessage());
        }

        return $this->writeJson('200', [], '安装成功');

    }

    public function test(){
        $task = TaskManager::getInstance();
        $taskId = $task->async(function (){
            echo "开始执行\n";
            sleep(10);
        });
        $this->response()->write($taskId);
    }

}