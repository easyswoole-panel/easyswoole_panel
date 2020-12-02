<?php

namespace App\Model;

/**
 * Class RoleModel
 * Create With Automatic Generator
 * @property $role_id int | 用户id
 * @property $role_name string | 角色名
 * @property $role_auth string | 角色权限
 * @property $role_status int | 角色状态 0正常1禁用
 * @property $level int | 角色级别 越小权限越高
 * @property $create_time int | 创建时间
 * @property $update_time int | 更新时间
 */
class RoleModel extends \App\Model\BaseModel
{
	protected $tableName = 'roles';


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
}

