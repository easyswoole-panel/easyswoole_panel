<?php

namespace App\Model\Auths;

/**
 * Class AuthsBean
 * Create With Automatic Generator
 * @property int auth_id | 权限id
 * @property string auth_name | 权限名
 * @property string auth_rules | 路由地址
 * @property string auth_icon | 图标
 * @property int auth_type | 权限类型 0菜单1按钮
 * @property int create_time | 创建时间
 * @property int update_time | 更新时间
 */
class AuthsBean extends \EasySwoole\Spl\SplBean
{
	protected $auth_id;

	protected $auth_name;

	protected $auth_rules;

	protected $auth_icon;

	protected $auth_type;

	protected $create_time;

	protected $update_time;


	public function setAuthId($auth_id)
	{
		$this->auth_id = $auth_id;
	}


	public function getAuthId()
	{
		return $this->auth_id;
	}


	public function setAuthName($auth_name)
	{
		$this->auth_name = $auth_name;
	}


	public function getAuthName()
	{
		return $this->auth_name;
	}


	public function setAuthRules($auth_rules)
	{
		$this->auth_rules = $auth_rules;
	}


	public function getAuthRules()
	{
		return $this->auth_rules;
	}


	public function setAuthIcon($auth_icon)
	{
		$this->auth_icon = $auth_icon;
	}


	public function getAuthIcon()
	{
		return $this->auth_icon;
	}


	public function setAuthType($auth_type)
	{
		$this->auth_type = $auth_type;
	}


	public function getAuthType()
	{
		return $this->auth_type;
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

