<?php

namespace App\Model\Users;

/**
 * 用户表
 * Class UsersBean
 * Create With Automatic Generator
 * @property int u_id |
 * @property string u_password | 用户密码
 * @property string u_name | 用户名
 * @property string u_account | 用户登录名
 * @property string p_u_id | 上级u_id
 * @property string role_id |
 * @property int u_status | 用户状态 -1删除 0禁用 1正常
 * @property string u_level_line | 用户层级链
 * @property int last_login_ip | 最后登录IP
 * @property int last_login_time | 最后登录时间
 * @property int create_time | 创建时间
 * @property int update_time | 更新时间
 * @property string u_auth |
 */
class UsersBean extends \EasySwoole\Spl\SplBean
{
	protected $u_id;

	protected $u_password;

	protected $u_name;

	protected $u_account;

	protected $p_u_id;

	protected $role_id;

	protected $u_status;

	protected $u_level_line;

	protected $last_login_ip;

	protected $last_login_time;

	protected $create_time;

	protected $update_time;

	protected $u_auth;


	public function setUId($u_id)
	{
		$this->u_id = $u_id;
	}


	public function getUId()
	{
		return $this->u_id;
	}


	public function setUPassword($u_password)
	{
		$this->u_password = $u_password;
	}


	public function getUPassword()
	{
		return $this->u_password;
	}


	public function setUName($u_name)
	{
		$this->u_name = $u_name;
	}


	public function getUName()
	{
		return $this->u_name;
	}


	public function setUAccount($u_account)
	{
		$this->u_account = $u_account;
	}


	public function getUAccount()
	{
		return $this->u_account;
	}


	public function setPUId($p_u_id)
	{
		$this->p_u_id = $p_u_id;
	}


	public function getPUId()
	{
		return $this->p_u_id;
	}


	public function setRoleId($role_id)
	{
		$this->role_id = $role_id;
	}


	public function getRoleId()
	{
		return $this->role_id;
	}


	public function setUStatus($u_status)
	{
		$this->u_status = $u_status;
	}


	public function getUStatus()
	{
		return $this->u_status;
	}


	public function setULevelLine($u_level_line)
	{
		$this->u_level_line = $u_level_line;
	}


	public function getULevelLine()
	{
		return $this->u_level_line;
	}


	public function setLastLoginIp($last_login_ip)
	{
		$this->last_login_ip = $last_login_ip;
	}


	public function getLastLoginIp()
	{
		return $this->last_login_ip;
	}


	public function setLastLoginTime($last_login_time)
	{
		$this->last_login_time = $last_login_time;
	}


	public function getLastLoginTime()
	{
		return $this->last_login_time;
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


	public function setUAuth($u_auth)
	{
		$this->u_auth = $u_auth;
	}


	public function getUAuth()
	{
		return $this->u_auth;
	}
}

