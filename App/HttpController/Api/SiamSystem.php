<?php

namespace App\HttpController\Api;

use App\Model\System\SiamSystemModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Class SiamSystem
 * Create With Automatic Generator
 */
class SiamSystem extends Base
{
	/**
	 * @api {get|post} /Api/SiamSystem/add
	 * @apiName add
	 * @apiGroup /Api/SiamSystem
	 * @apiPermission
	 * @apiDescription add新增数据
	 * @Param(name="id", alias="", required="", lengthMax="11")
	 * @Param(name="user_next_id", alias="下一个用户id", required="", lengthMax="11")
	 * @Param(name="auth_order", alias="权限排序", required="", lengthMax="300")
	 * @apiParam {int} id
	 * @apiParam {int} user_next_id 下一个用户id
	 * @apiParam {string} auth_order 权限排序
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
     * @throws
     */
    public function add()
    {
        $param = $this->request()->getRequestParam();
        $data  = [
            'id'           => $param['id'],
            'user_next_id' => $param['user_next_id'],
            'auth_order'   => $param['auth_order'] ?? '[]',
        ];
		$model = new SiamSystemModel($data);
		$rs = $model->save();
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $model->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/SiamSystem/update
	 * @apiName update
	 * @apiGroup /Api/SiamSystem
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @Param(name="id", alias="", optional="", lengthMax="11")
	 * @Param(name="user_next_id", alias="下一个用户id", optional="", lengthMax="11")
	 * @Param(name="auth_order", alias="权限排序", optional="", lengthMax="300")
	 * @apiParam {int} id 主键id
	 * @apiParam {int} [id]
	 * @apiParam {int} [user_next_id] 下一个用户id
	 * @apiParam {mixed} [auth_order] 权限排序
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
		$param = $this->request()->getRequestParam();
		$model = new SiamSystemModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['id'] = $param['id']??$info->id;
		$updateData['user_next_id'] = $param['user_next_id']??$info->user_next_id;
		$updateData['auth_order'] = $param['auth_order']??$info->auth_order;
		$rs = $info->update($updateData);
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $rs, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/SiamSystem/getOne
	 * @apiName getOne
	 * @apiGroup /Api/SiamSystem
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @Param(name="id", alias="", optional="", lengthMax="11")
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
		$param = $this->request()->getRequestParam();
		$model = new SiamSystemModel();
		$bean = $model->get(['id' => $param['id']]);
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/SiamSystem/getAll
	 * @apiName getAll
	 * @apiGroup /Api/SiamSystem
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
		$param = $this->request()->getRequestParam();
		$page = (int)($param['page']??1);
		$limit = (int)($param['limit']??20);
		$model = new SiamSystemModel();
		$data = $model->getAll($page, $param['keyword']??null, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/SiamSystem/delete
	 * @apiName delete
	 * @apiGroup /Api/SiamSystem
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @Param(name="id", alias="", optional="", lengthMax="11")
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
		$param = $this->request()->getRequestParam();
		$model = new SiamSystemModel();

		$rs = $model->destroy(['id' => $param['id']]);
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, [], "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}

    protected function getValidateRule(?string $action): ?Validate
    {
        // TODO: Implement getValidateRule() method.
    }
}

