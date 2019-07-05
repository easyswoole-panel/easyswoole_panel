<?php

namespace App\Model\Users;

use App\Model\Auths\AuthsModel;
use App\Model\Roles\RolesModel;
use EasySwoole\Mysqli\Exceptions\ConnectFail;
use EasySwoole\Mysqli\Exceptions\PrepareQueryFail;
use http\Client\Curl\User;

/**
 * 用户表
 * Class UsersModel
 * Create With Automatic Generator
 */
class UsersModel extends \App\Model\BaseModel
{
	protected $table = 'siam_users';

	protected $primaryKey = 'u_id';


	/**
	 * @getAll
	 * @keyword u_name
	 * @param  int  $page  1
	 * @param  string  $keyword
	 * @param  int  $pageSize  10
	 * @param  string  $field  *
	 * @return array[total,list]
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10, string $field = '*'): array
	{
		if (!empty($keyword)) {
		    $this->getDb()->where('u_name', '%' . $keyword . '%', 'like');
		}
		$list = $this->getDb()
		    ->withTotalCount()
		    ->orderBy($this->primaryKey, 'DESC')
		    ->get($this->table, [$pageSize * ($page  - 1), $pageSize],$field);
		$total = $this->getDb()->getTotalCount();
		return ['total' => $total, 'list' => $list];
	}


	/**
	 * 默认根据主键(u_id)进行搜索
	 * @getOne
	 * @param  UsersBean $bean
	 * @param  string $field
	 * @return UsersBean
	 */
	public function getOne(UsersBean $bean, string $field = '*'): ?UsersBean
	{
		$info = $this->getDb()->where($this->primaryKey, $bean->getUId())->getOne($this->table,$field);
		if (empty($info)) {
		    return null;
		}
		return new UsersBean($info);
	}

	public function getOneByAccount(UsersBean $bean, string  $field = '*'): ?UsersBean
    {
        $info = null;
        try {
            $info = $this->getDb()->where('u_account', $bean->getUAccount())->getOne($this->table, $field);
        } catch (ConnectFail $e) {
        } catch (PrepareQueryFail $e) {
        } catch (\Throwable $e) {
        }
        if (empty($info)) {
            return null;
        }
        return new UsersBean($info);
    }


	/**
	 * 默认根据bean数据进行插入数据
	 * @add
	 * @param  UsersBean $bean
	 * @return bool
	 */
	public function add(UsersBean $bean): bool
	{
		return $this->getDb()->insert($this->table, $bean->toArray(null, $bean::FILTER_NOT_NULL));
	}


	/**
	 * 默认根据主键(u_id)进行删除
	 * @delete
	 * @param  UsersBean $bean
	 * @return bool
	 */
	public function delete(UsersBean $bean): bool
	{
		return  $this->getDb()->where($this->primaryKey, $bean->getUId())->delete($this->table);
	}


	/**
	 * 默认根据主键(u_id)进行更新
	 * @delete
	 * @param  UsersBean $bean
	 * @param  array $data
	 * @return bool
	 */
	public function update(UsersBean $bean, array $data): bool
	{
		if (empty($data)){
		    return false;
		}
		return $this->getDb()->where($this->primaryKey, $bean->getUId())->update($this->table, $data);
	}

	public function getAuth(int $uId)
    {
        $info = $this->getOne(new UsersBean(['u_id' => $uId]), 'u_id,u_auth,role_id');

        if ($info == null) return [];

        // 角色权限
        $roleIds = explode(',', $info->toArray()['role_id']);

        // 管理员 全部权限
        if(in_array(1, $roleIds)){
            $authsModel = new AuthsModel($this->getDb());
            $auths      = $authsModel->all();
            return $auths;
        }

        $roleModel = new RolesModel($this->getDb());
        $roleList = $roleModel->getIn('role_id', $roleIds);

        // 个人权限
        $authIds = explode(',', $info->toArray()['u_auth']);

        // 如果有角色权限 则合并
        if(!empty($roleList)){
            foreach ($roleList as $row){
                $tem     = explode(',', $row['role_auth']);
                $authIds = array_merge($authIds, $tem);
            }
        }
        $authIds = array_unique($authIds);

        if (!empty($authIds)){
            $auths = new AuthsModel($this->getDb());
            $list = $auths->getIn('auth_id', $authIds, 'auth_id,auth_name,auth_rules,auth_icon,auth_type');
            return $list;
        }

        return [];

    }
}

