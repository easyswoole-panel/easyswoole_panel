<?php

namespace App\HttpController\Common;


use App\HttpController\Api\SiamSystem;
use App\Model\System\SiamSystemModel;
use App\Model\System\SystemBean;
use App\Model\System\SystemModel;
use App\Model\Users\SiamUserModel;
use App\Model\Users\UsersModel;
use EasySwoole\MysqliPool\Mysql;

class Menu
{
    private $auth_list;
    private $onlyMenu = true;

    public function setOnlyMenu(bool $only){
        $this->onlyMenu = $only;
    }

    /**
     * @param int $uid
     * @return array
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function get(int $uid)
    {
        // 先 u_id 查询 分析权限  角色权限+个人权限
        $lists = SiamUserModel::create()->get(['u_id' => $uid])->getAuth();

        $newList = [];

        foreach ($lists as $key => $value){
            $newList[$value['auth_id']] = $value;
        }

        $this->auth_list = $newList;

        $systemInfo = SiamSystemModel::create()->get(1);

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
            if ( isset($value['child'] ) ){
                // unset($tem['auth_rules']);
                $tem['childs'] = $this->makeTree($value['child']);
            }
            $return[] = $tem;
        }
        return $return;
    }
}