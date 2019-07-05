<?php

namespace App\HttpController\Api;

use EasySwoole\MysqliPool\Mysql;
use App\Model\Roles\RolesBean;
use App\Model\Roles\RolesModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Class Roles
 * Create With Automatic Generator
 */
class Roles extends Base
{
	/**
	 * @api {get|post} /Api/Roles/add
	 * @apiName add
	 * @apiGroup /Api/Roles
	 * @apiPermission
	 * @apiDescription add新增数据
	 * @apiParam {string} role_name 角色名
	 * @apiParam {string} role_auth 角色权限
	 * @apiParam {int} role_status 角色状态 0正常1禁用
	 * @apiParam {int} level 角色级别 越小权限越高
	 * @apiParam {int} create_time 创建时间
	 * @apiParam {int} update_time 更新时间
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
		$model = new RolesModel($db);
		$bean = new RolesBean();
		$bean->setRoleName($param['role_name']);
		$bean->setRoleAuth($param['role_auth']);
		$bean->setRoleStatus($param['role_status']);
		$bean->setLevel($param['level']);
		$bean->setCreateTime($param['create_time']);
		$bean->setUpdateTime($param['update_time']);
		$rs = $model->add($bean);
		if ($rs) {
		    $bean->setRoleId($db->getInsertId());
		    $this->writeJson(Status::CODE_OK, $bean->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/Roles/update
	 * @apiName update
	 * @apiGroup /Api/Roles
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @apiParam {int} role_id 主键id
	 * @apiParam {string} [role_name] 角色名
	 * @apiParam {string} [role_auth] 角色权限
	 * @apiParam {int} [role_status] 角色状态 0正常1禁用
	 * @apiParam {int} [level] 角色级别 越小权限越高
	 * @apiParam {int} [create_time] 创建时间
	 * @apiParam {int} [update_time] 更新时间
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
		$model = new RolesModel($db);
		$bean = $model->getOne(new RolesBean(['role_id' => $param['role_id']]));
		if (empty($bean)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateBean = new RolesBean();

		$updateBean->setRoleName($param['role_name']??$bean->getRoleName());
		$updateBean->setRoleAuth($param['role_auth']??$bean->getRoleAuth());
		$updateBean->setRoleStatus($param['role_status']??$bean->getRoleStatus());
		$updateBean->setLevel($param['level']??$bean->getLevel());
		$updateBean->setCreateTime($param['create_time']??$bean->getCreateTime());
		$updateBean->setUpdateTime($param['update_time']??$bean->getUpdateTime());
		$rs = $model->update($bean, $updateBean->toArray([], $updateBean::FILTER_NOT_EMPTY));
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $rs, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/Roles/getOne
	 * @apiName getOne
	 * @apiGroup /Api/Roles
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @apiParam {int} role_id 主键id
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
		$model = new RolesModel($db);
		$bean = $model->getOne(new RolesBean(['role_id' => $param['role_id']]));
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/Roles/getAll
	 * @apiName getAll
	 * @apiGroup /Api/Roles
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
		$model = new RolesModel($db);
		$data = $model->getAll($page, $param['keyword']??null, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/Roles/delete
	 * @apiName delete
	 * @apiGroup /Api/Roles
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @apiParam {int} role_id 主键id
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
		$model = new RolesModel($db);

		$rs = $model->delete(new RolesBean(['role_id' => $param['role_id']]));
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

