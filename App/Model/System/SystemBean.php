<?php

namespace App\Model\System;

/**
 * Class SystemBean
 * Create With Automatic Generator
 * @property int id |
 * @property int user_next_id | 下一个用户id
 * @property string auth_order | 权限排序
 */
class SystemBean extends \EasySwoole\Spl\SplBean
{
	protected $id;

	protected $user_next_id;

	protected $auth_order;


	public function setId($id)
	{
		$this->id = $id;
	}


	public function getId()
	{
		return $this->id;
	}


	public function setUserNextId($user_next_id)
	{
		$this->user_next_id = $user_next_id;
	}


	public function getUserNextId()
	{
		return $this->user_next_id;
	}


	public function setAuthOrder($auth_order)
	{
		$this->auth_order = $auth_order;
	}


	public function getAuthOrder()
	{
		return $this->auth_order;
	}
}

