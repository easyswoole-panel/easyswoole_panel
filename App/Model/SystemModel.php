<?php

namespace App\Model;

use EasySwoole\ORM\Exception\Exception;

/**
 * Class SystemModel
 * Create With Automatic Generator
 * @property $id int |
 * @property $user_next_id int | 下一个用户id
 * @property $auth_order string | 权限排序
 */
class SystemModel extends \App\Model\BaseModel
{
	protected $tableName = 'system';


    /**
     * @getAll
     * @param int $page 1
     * @param int $pageSize 10
     * @param string $field *
     * @return array[total,list]
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
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
        $return = $this->user_next_id;
        try {
            $this->setAttr("user_next_id", $return + 1);
            try {
                $this->update();
            } catch (Exception $e) {
            } catch (\Throwable $e) {
            }
        } catch (Exception $e) {
        }
        return $return;
    }
}

