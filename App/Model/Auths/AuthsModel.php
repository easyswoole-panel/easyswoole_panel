<?php

namespace App\Model\Auths;

/**
 * Class AuthsModel
 * Create With Automatic Generator
 */
class AuthsModel extends \App\Model\BaseModel
{
	protected $table = 'siam_auths';

	protected $primaryKey = 'auth_id';


	/**
	 * @getAll
	 * @keyword auth_name
	 * @param  int  $page  1
	 * @param  string  $keyword
	 * @param  int  $pageSize  10
	 * @param  string  $field  *
	 * @return array[total,list]
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10, string $field = '*'): array
	{
		if (!empty($keyword)) {
		    $this->getDb()->where('auth_name', '%' . $keyword . '%', 'like');
		}
		$list = $this->getDb()
		    ->withTotalCount()
		    ->orderBy($this->primaryKey, 'DESC')
		    ->get($this->table, [$pageSize * ($page  - 1), $pageSize],$field);
		$total = $this->getDb()->getTotalCount();
		return ['total' => $total, 'list' => $list];
	}


	/**
	 * 默认根据主键(auth_id)进行搜索
	 * @getOne
	 * @param  AuthsBean $bean
	 * @param  string $field
	 * @return AuthsBean
	 */
	public function getOne(AuthsBean $bean, string $field = '*'): ?AuthsBean
	{
		$info = $this->getDb()->where($this->primaryKey, $bean->getAuthId())->getOne($this->table,$field);
		if (empty($info)) {
		    return null;
		}
		return new AuthsBean($info);
	}


	/**
	 * 默认根据bean数据进行插入数据
	 * @add
	 * @param  AuthsBean $bean
	 * @return bool
	 */
	public function add(AuthsBean $bean): bool
	{
		return $this->getDb()->insert($this->table, $bean->toArray(null, $bean::FILTER_NOT_NULL));
	}


	/**
	 * 默认根据主键(auth_id)进行删除
	 * @delete
	 * @param  AuthsBean $bean
	 * @return bool
	 */
	public function delete(AuthsBean $bean): bool
	{
		return  $this->getDb()->where($this->primaryKey, $bean->getAuthId())->delete($this->table);
	}


	/**
	 * 默认根据主键(auth_id)进行更新
	 * @delete
	 * @param  AuthsBean $bean
	 * @param  array $data
	 * @return bool
	 */
	public function update(AuthsBean $bean, array $data): bool
	{
		if (empty($data)){
		    return false;
		}
		return $this->getDb()->where($this->primaryKey, $bean->getAuthId())->update($this->table, $data);
	}
}

