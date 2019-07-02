<?php

namespace App\HttpController\Api;

use App\HttpController\EasySwoole\MysqliPool\Mysql;
use App\Model\System\SystemBean;
use App\Model\System\SystemModel;
use EasySwoole\Http\Message\Status;

/**
 * Class System
 * Create With Automatic Generator
 */
class System extends Base
{
	/**
	 * @api {get|post} /Api/System/add
	 * @apiName add
	 * @apiGroup /Api/System
	 * @apiPermission
	 * @apiDescription add新增数据
	 * @apiParam {int} user_next_id 下一个用户id
	 * @apiParam {string} auth_order 权限排序
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
	 */
	public function add()
	{
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new SystemModel($db);
		$bean = new SystemBean();
		$bean->setUserNextId($param['user_next_id']);
		$bean->setAuthOrder($param['auth_order']);
		$rs = $model->add($bean);
		if ($rs) {
		    $bean->setId($db->getInsertId());
		    $this->writeJson(Status::CODE_OK, $bean->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/System/update
	 * @apiName update
	 * @apiGroup /Api/System
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @apiParam {int} id 主键id
	 * @apiParam {int} [user_next_id] 下一个用户id
	 * @apiParam {string} [auth_order] 权限排序
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
	 */
	public function update()
	{
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new SystemModel($db);
		$bean = $model->getOne(new SystemBean(['id' => $param['id']]));
		if (empty($bean)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateBean = new SystemBean();

		$updateBean->setUserNextId($param['user_next_id']??$bean->getUserNextId());
		$updateBean->setAuthOrder($param['auth_order']??$bean->getAuthOrder());
		$rs = $model->update($bean, $updateBean->toArray([], $updateBean::FILTER_NOT_EMPTY));
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $rs, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/System/getOne
	 * @apiName getOne
	 * @apiGroup /Api/System
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @apiParam {int} id 主键id
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
	 */
	public function getOne()
	{
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new SystemModel($db);
		$bean = $model->getOne(new SystemBean(['id' => $param['id']]));
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/System/getAll
	 * @apiName getAll
	 * @apiGroup /Api/System
	 * @apiPermission
	 * @apiDescription 获取一个列表
	 * @apiParam {String} [page=1]
	 * @apiParam {String} [limit=20]
	 * @apiParam {String} [keyword] 关键字,根据表的不同而不同
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
	 */
	public function getAll()
	{
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$page = (int)$param['page']??1;
		$limit = (int)$param['limit']??20;
		$model = new SystemModel($db);
		$data = $model->getAll($page, $param['keyword']??null, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/System/delete
	 * @apiName delete
	 * @apiGroup /Api/System
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @apiParam {int} id 主键id
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
	 */
	public function delete()
	{
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new SystemModel($db);

		$rs = $model->delete(new SystemBean(['id' => $param['id']]));
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, [], "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}

    protected function getValidateRule(?string $action): ?bool
    {
        // TODO: Implement getValidateRule() method.
    }
}

