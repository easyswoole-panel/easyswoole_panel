<?php

namespace App\HttpController\Api;

use EasySwoole\FastCache\Cache;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

class System extends Base
{
    /**
     * 管理员清空所有 shouldvif_api_  policy_
     */
    public function clearCache()
    {
        $cache = Cache::getInstance();
        $keys  = $cache->keys();
        $str   = '';

        foreach ($keys as $key => $value){
            // 是shouldvif_api_ / policy_ 清空用户权限缓存
            if (strstr($value,'shouldvif_api_' ) || strstr($value,'policy_')){
                $cache->unset($value);
                $str .= "{$value} 已经清空<br/>";
            }
        }

        $this->writeJson(Status::CODE_OK, ['res' => $str], "SUCCESS");
    }

    /**
     * 查询cache列表
     */
    public function showCache(){
        $cache = Cache::getInstance();
        $keys  = $cache->keys();

        $str = '';
        foreach ($keys as $key => $value){
            $str .= "{$value}<br/>";
        }

        $this->writeJson(Status::CODE_OK, ['res' => $str], "SUCCESS");
    }
    
    protected function getValidateRule(?string $action): ?Validate
    {
        // TODO: Implement getValidateRule() method.
        return null;
    }

}