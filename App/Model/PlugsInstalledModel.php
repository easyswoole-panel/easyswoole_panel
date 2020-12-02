<?php

namespace App\Model;

use EasySwoole\ORM\AbstractModel;

/**
 * SiamPlugsInstalledModel
 * Class SiamPlugsInstalledModel
 * Create With ClassGeneration
 * @property int $id //
 * @property string $plugs_name // 插件包名
 * @property string $plugs_version // 插件包版本号
 * @property mixed $create_time // 安装时间
 */
class PlugsInstalledModel extends BaseModel
{
	protected $tableName = 'plugs_installed';


	public function getList(int $page = 1, int $pageSize = 10, string $field = '*'): array
	{
		$list = $this
		    ->withTotalCount()
			->order($this->schemaInfo()->getPkFiledName(), 'DESC')
		    ->field($field)
		    ->page($page, $pageSize)
		    ->all();
		$total = $this->lastQueryResult()->getTotalCount();
		$data = [
		    'page'=>$page,
		    'pageSize'=>$pageSize,
		    'list'=>$list,
		    'total'=>$total,
		    'pageCount'=>ceil($total / $pageSize)
		];
		return $data;
	}
}

