<?php

namespace App\Model\Users;
use App\Model\Auths\SiamAuthModel;
use App\Model\Roles\SiamRoleModel;

/**
 * Class SiamUserModel
 * Create With Automatic Generator
 * @property $u_id int |
 * @property $u_password string | 用户密码
 * @property $u_name string | 用户名
 * @property $u_account string | 用户登录名
 * @property $p_u_id string | 上级u_id
 * @property $role_id string |
 * @property $u_status int | 用户状态 -1删除 0禁用 1正常
 * @property $u_level_line string | 用户层级链
 * @property $last_login_ip string | 最后登录IP
 * @property $last_login_time int | 最后登录时间
 * @property $create_time int | 创建时间
 * @property $update_time int | 更新时间
 * @property $u_auth string |
 */
class SiamUserModel extends \App\Model\BaseModel
{
	protected $tableName = 'siam_users';


	/**
	 * @getAll
	 * @param  int  $page  1
	 * @param  int  $pageSize  10
	 * @param  string  $field  *
	 * @return array[total,list]
	 */
	public function getAll(int $page = 1, int $pageSize = 10, string $field = '*'): array
	{
		$list = $this
		    ->withTotalCount()
			->order($this->schemaInfo()->getPkFiledName(), 'DESC')
		    ->field($field)
		    ->limit($pageSize * ($page - 1), $pageSize)
		    ->all();
		$total = $this->lastQueryResult()->getTotalCount();;
		return ['total' => $total, 'list' => $list];
	}

    /**
     * @return AuthsModel|array|bool
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
	public function getAuth()
    {
        // 角色权限
        $roleIds = explode(',', $this->role_id);

        // 管理员 全部权限
        if(in_array(1, $roleIds)) {
            $auths = SiamAuthModel::create()->all();
            return $auths;
        }

        $roleList = SiamRoleModel::create()->where('role_id', $roleIds, 'in')->all();

        // 个人权限
        $authIds = explode(',', $this->u_auth);

        // 如果有角色权限 则合并
        if(!empty($roleList)){
            foreach ($roleList as $row){
                $tem     = explode(',', $row['role_auth']);
                $authIds = array_merge($authIds, $tem);
            }
        }
        $authIds = array_unique($authIds);

        if (!empty($authIds)){
            $list =
                SiamAuthModel::create()->where('auth_id', $authIds, 'in')->field('auth_id,auth_name,auth_rules,auth_icon,auth_type')->all();
            return $list;
        }

        return [];
    }
}

