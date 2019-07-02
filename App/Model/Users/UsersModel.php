<?php

namespace App\Model\Users;

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
}

