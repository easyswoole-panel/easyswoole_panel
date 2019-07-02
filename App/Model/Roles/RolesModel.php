<?php

namespace App\Model\Roles;

/**
 * Class RolesModel
 * Create With Automatic Generator
 */
class RolesModel extends \App\Model\BaseModel
{
	protected $table = 'siam_roles';

	protected $primaryKey = 'role_id';


	/**
	 * @getAll
	 * @keyword role_name
	 * @param  int  $page  1
	 * @param  string  $keyword
	 * @param  int  $pageSize  10
	 * @param  string  $field  *
	 * @return array[total,list]
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10, string $field = '*'): array
	{
		if (!empty($keyword)) {
		    $this->getDb()->where('role_name', '%' . $keyword . '%', 'like');
		}
		$list = $this->getDb()
		    ->withTotalCount()
		    ->orderBy($this->primaryKey, 'DESC')
		    ->get($this->table, [$pageSize * ($page  - 1), $pageSize],$field);
		$total = $this->getDb()->getTotalCount();
		return ['total' => $total, 'list' => $list];
	}


	/**
	 * 默认根据主键(role_id)进行搜索
	 * @getOne
	 * @param  RolesBean $bean
	 * @param  string $field
	 * @return RolesBean
	 */
	public function getOne(RolesBean $bean, string $field = '*'): ?RolesBean
	{
		$info = $this->getDb()->where($this->primaryKey, $bean->getRoleId())->getOne($this->table,$field);
		if (empty($info)) {
		    return null;
		}
		return new RolesBean($info);
	}


	/**
	 * 默认根据bean数据进行插入数据
	 * @add
	 * @param  RolesBean $bean
	 * @return bool
	 */
	public function add(RolesBean $bean): bool
	{
		return $this->getDb()->insert($this->table, $bean->toArray(null, $bean::FILTER_NOT_NULL));
	}


	/**
	 * 默认根据主键(role_id)进行删除
	 * @delete
	 * @param  RolesBean $bean
	 * @return bool
	 */
	public function delete(RolesBean $bean): bool
	{
		return  $this->getDb()->where($this->primaryKey, $bean->getRoleId())->delete($this->table);
	}


	/**
	 * 默认根据主键(role_id)进行更新
	 * @delete
	 * @param  RolesBean $bean
	 * @param  array $data
	 * @return bool
	 */
	public function update(RolesBean $bean, array $data): bool
	{
		if (empty($data)){
		    return false;
		}
		return $this->getDb()->where($this->primaryKey, $bean->getRoleId())->update($this->table, $data);
	}
}

