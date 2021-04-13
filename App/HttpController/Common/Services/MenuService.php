<?php

namespace App\HttpController\Common\Services;

use App\Model\AuthModel;
use App\Model\SystemModel;
use App\Model\UserModel;

class MenuService
{
    private $auth_list;
    private $onlyMenu = true;

    public function setOnlyMenu(bool $only){
        $this->onlyMenu = $only;
    }

    /**
     * @param int $uid
     * @return array
     * @throws \Throwable
     */
    public function get(int $uid)
    {
        // 先 u_id 查询 分析权限  角色权限+个人权限
        $lists = UserModel::create()->get(['u_id' => $uid])->getAuth();

        $newList = [];
        foreach ($lists as $key => $value){
            $newList[$value['auth_id']] = $value;
        }
        $this->auth_list = $newList;

        $systemInfo = SystemModel::create()->get(1);

        if ($systemInfo == null){
            return [];
        }

        $order  = json_decode($systemInfo->toArray()['auth_order'], TRUE);


        $return = $this->makeTree($order);
        return $return;
    }

    private function makeTree($child)
    {
        $return = [];
        foreach ($child as $key => $value){
            // 未有权限
            if ( empty($this->auth_list[$value['id']] )){
                continue;
            }
            // 如果只需要获取菜单
            if (true == $this->onlyMenu){
                if ($this->auth_list[$value['id']]['auth_type'] != '1'){
                    continue;
                }
            }
            $tem = $this->auth_list[$value['id']];
            
            if ($tem instanceof AuthModel) {
                $tem = $tem->toArray();
            }
            
            if ( isset($value['child'] ) ){
                // unset($tem['auth_rules']);
                $tem['childs'] = $this->makeTree($value['child']);
            }
            $return[] = $tem;
        }
        return $return;
    }
}