<?php


namespace App\Service\Plugs;


use App\Model\PlugsInstalledModel;
use EasySwoole\Utility\File;

class PlugsInstallService
{
    /**
     * 插件是否已经安装
     * @param $plugsName
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public static function isInstalled($plugsName)
    {
        $installedModel = PlugsInstalledModel::create()->get([
            'plugs_name' => $plugsName
        ]);
        return !!$installedModel ?? false;
    }

    public static function install($plugsName, $newInstall = true)
    {
        // 是否全新安装，是则需要遍历第一个版本到最后一个版本到安装
        if (!$newInstall){
            $model = PlugsInstalledModel::create()->get([
                'plugs_name' => $plugsName
            ]);
            $installFileList = static::getInstallFIle($plugsName, (string) $model->plugs_version);
        }else{
            $installFileList = static::getInstallFIle($plugsName);
        }
        
        foreach ($installFileList as $installFile){
            // run install
            require $installFile;
        }
    }

    /**
     * 获取安装文件列表
     * @param $plugsName
     * @param null $startVersion
     * @param null $endVersion
     * @return array
     */
    public static function getInstallFIle($plugsName, $startVersion = null, $endVersion = null)
    {
        $config = PlugsAuthService::getPlugsConfig($plugsName);
        $namespace = $config['namespace'];
        $version   = $config['version'];
        // 获取到起点和终点版本到文件列表
        $installFilePath = PlugsAuthService::plugsPath($plugsName)."/src/database/";
        $allInstallFile = File::scanDirectory($installFilePath);
        $allInstallFile = $allInstallFile["files"];
        $return = [];
        foreach ($allInstallFile as $oneFile){
            $return[] = str_replace($installFilePath."install_", "", $oneFile);
        }
        // 排序
        asort($return , SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
        $finalReturn = [];
        // 根据start和end 筛选
        $start = false;
        if ($startVersion===null) $start = true;
        foreach ($return as $version){
            if (!$start){
                if ($startVersion.".php" == $version){
                    $start = true;
                }
                continue;
            }
            $finalReturn[] = $installFilePath."install_".$version;
        }

        return $finalReturn;
    }
}