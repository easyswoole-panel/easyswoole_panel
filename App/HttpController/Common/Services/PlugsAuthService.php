<?php
/**
 * 插件认证逻辑
 * User: Siam
 * Date: 2020/12/1 0001
 * Time: 21:20
 */

namespace App\HttpController\Common\Services;


class PlugsAuthService
{
    const configName = "esPlugsConfig.php";
    public static function plugsPath($vendorName)
    {
        $vendorPath = EASYSWOOLE_ROOT."/vendor/".$vendorName."/";
        return $vendorPath;
    }

    /**
     * 是否为插件
     * @param $vendorName
     * @return bool
     */
    public static function isPlugs($vendorName)
    {
        $vendorPath = static::plugsPath($vendorName);

        if (is_file($vendorPath.static::configName)){
            return true;
        }
        return false;
    }

    /**
     * 获取插件配置
     * @param $vendorName
     * @return mixed|null
     */
    public static function getPlugsConfig($vendorName)
    {
        $vendorPath = static::plugsPath($vendorName);

        if (is_file($vendorPath.static::configName)){
            $fullPath =  $vendorPath.static::configName;
            $config = require $fullPath;
            return $config;
        }
        return null;
    }
}