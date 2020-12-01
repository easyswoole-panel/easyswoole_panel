<?php

namespace App\Model\Roles;

/**
 * Class RolesBean
 * Create With Automatic Generator
 * @property int role_id | 用户id
 * @property string role_name | 角色名
 * @property string role_auth | 角色权限
 * @property int role_status | 角色状态 0正常1禁用
 * @property int level | 角色级别 越小权限越高
 * @property int create_time | 创建时间
 * @property int update_time | 更新时间
 */
class RolesBean extends \EasySwoole\Spl\SplBean
{
	protected $role_id;

	protected $role_name;

	protected $role_auth;

	protected $role_status;

	protected $level;

	protected $create_time;

	protected $update_time;


	public function setRoleId($role_id)
	{
		$this->role_id = $role_id;
	}


	public function getRoleId()
	{
		return $this->role_id;
	}


	public function setRoleName($role_name)
	{
		$this->role_name = $role_name;
	}


	public function getRoleName()
	{
		return $this->role_name;
	}


	public function setRoleAuth($role_auth)
	{
		$this->role_auth = $role_auth;
	}


	public function getRoleAuth()
	{
		return $this->role_auth;
	}


	public function setRoleStatus($role_status)
	{
		$this->role_status = $role_status;
	}


	public function getRoleStatus()
	{
		return $this->role_status;
	}


	public function setLevel($level)
	{
		$this->level = $level;
	}


	public function getLevel()
	{
		return $this->level;
	}


	public function setCreateTime($create_time)
	{
		$this->create_time = $create_time;
	}


	public function getCreateTime()
	{
		return $this->create_time;
	}


	public function setUpdateTime($update_time)
	{
		$this->update_time = $update_time;
	}


	public function getUpdateTime()
	{
		return $this->update_time;
	}
}

