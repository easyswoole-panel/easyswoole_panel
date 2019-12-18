<?php

namespace App\Model\System;

/**
 * Class SiamSystemModel
 * Create With Automatic Generator
 * @property $id int |
 * @property $user_next_id int | 下一个用户id
 * @property $auth_order string | 权限排序
 */
class SiamSystemModel extends \App\Model\BaseModel
{
	protected $tableName = 'siam_system';


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
     * 获取新账号
     */
    public function getNewAccount()
    {
        return $this->user_next_id;
    }
}

