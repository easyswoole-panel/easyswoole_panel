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

    }

}