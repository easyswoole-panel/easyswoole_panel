<?php
/**
 * 面板内部接口 不建议修改
 * User: Siam
 * Date: 2020/12/1 0001
 * Time: 21:09
 */

namespace App\HttpController\Panel;

use App\HttpController\Common\Services\PlugsAuthService;
use EasySwoole\Http\AbstractInterface\Controller;

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
            }
        }
        // todo 从数据库判断是否已经安装

        $this->writeJson(200, $return);
    }

    /**
     * TODO 通过插件名 扫描运行包内的install逻辑
     */
    public function install()
    {
        $vendorName = "siam/testPlugs";
        if (!PlugsAuthService::isPlugs($vendorName)){
            return $this->writeJson('500', [], '不是合法插件');
        }

        $config = PlugsAuthService::getPlugsConfig($vendorName);
        $namespace = $config['namespace'];
        $version   = $config['version'];
        // TODO 对比数据库是否安装过 版本号

        // 运行database脚本
        $installFilePath = PlugsAuthService::plugsPath($vendorName)."/src/database/install_{$version}.php";
        if (!is_file($installFilePath)){
            return $this->writeJson('500',[],'安装脚本不存在');
        }
        try{
            require $installFilePath;
        }catch (\Throwable $e){
            return $this->writeJson('500', [], $e->getMessage());
        }

        return $this->writeJson('200', [], '安装成功');

    }

}