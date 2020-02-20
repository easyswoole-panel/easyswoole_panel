<?php

namespace App\HttpController\Api;

use App\Model\Roles\SiamRoleModel;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Class SiamRole
 * Create With Automatic Generator
 */
class Roles extends Base
{
	/**
	 * @api {get|post} /Api/SiamRole/add
	 * @apiName add
	 * @apiGroup /Api/SiamRole
	 * @apiPermission
	 * @apiDescription add新增数据
	 * @Param(name="role_id", alias="用户id", required="", lengthMax="11")
	 * @Param(name="role_name", alias="角色名", required="", lengthMax="40")
	 * @Param(name="role_auth", alias="角色权限", required="", lengthMax="255")
	 * @Param(name="role_status", alias="角色状态 0正常1禁用", required="", lengthMax="1")
	 * @Param(name="level", alias="角色级别 越小权限越高", required="", lengthMax="1")
	 * @Param(name="create_time", alias="创建时间", required="", lengthMax="11")
	 * @Param(name="update_time", alias="更新时间", required="", lengthMax="11")
	 * @apiParam {int} role_id 用户id
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
     * @throws
	 */
	public function add()
    {
        $param = $this->request()->getRequestParam();
        $data  = [
            'role_name'   => $param['role_name'],
            'role_auth'   => $param['role_auth'] ?? '0',
            'role_status' => $param['role_status'] ?? '0',
            'level'       => $param['level'] ?? '0',
            'create_time' => $param['create_time'] ?? '0',
            'update_time' => $param['update_time'] ?? '0',
        ];
        $model = new SiamRoleModel($data);
		$rs = $model->save();
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $model->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/SiamRole/update
	 * @apiName update
	 * @apiGroup /Api/SiamRole
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @Param(name="role_id", alias="用户id", optional="", lengthMax="11")
	 * @Param(name="role_name", alias="角色名", optional="", lengthMax="40")
	 * @Param(name="role_auth", alias="角色权限", optional="", lengthMax="255")
	 * @Param(name="role_status", alias="角色状态 0正常1禁用", optional="", lengthMax="1")
	 * @Param(name="level", alias="角色级别 越小权限越高", optional="", lengthMax="1")
	 * @Param(name="create_time", alias="创建时间", optional="", lengthMax="11")
	 * @Param(name="update_time", alias="更新时间", optional="", lengthMax="11")
	 * @apiParam {int} role_id 主键id
	 * @apiParam {int} [role_id] 用户id
	 * @apiParam {mixed} [role_name] 角色名
	 * @apiParam {mixed} [role_auth] 角色权限
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
     * @throws
	 */
	public function update()
	{
		$param = $this->request()->getRequestParam();
		$model = new SiamRoleModel();
		$info = $model->get(['role_id' => $param['role_id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['role_id'] = $param['role_id']??$info->role_id;
		$updateData['role_name'] = $param['role_name']??$info->role_name;
		$updateData['role_auth'] = $param['role_auth']??$info->role_auth;
		$updateData['role_status'] = $param['role_status']??$info->role_status;
		$updateData['level'] = $param['level']??$info->level;
		$updateData['create_time'] = $param['create_time']??$info->create_time;
		$updateData['update_time'] = $param['update_time']??$info->update_time;
		$rs = $info->update($updateData);
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $rs, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/SiamRole/getOne
	 * @apiName getOne
	 * @apiGroup /Api/SiamRole
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @Param(name="role_id", alias="用户id", optional="", lengthMax="11")
	 * @apiParam {int} role_id 主键id
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
     * @throws
	 */
	public function getOne()
	{
		$param = $this->request()->getRequestParam();
		$model = new SiamRoleModel();
		$bean = $model->get(['role_id' => $param['role_id']]);
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/SiamRole/getAll
	 * @apiName getAll
	 * @apiGroup /Api/SiamRole
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
     * @throws
	 */
	public function getAll()
    {
        $param = $this->request()->getRequestParam();
        $page  = (int) ($param['page'] ?? 1);
        $limit = (int) ($param['limit'] ?? 20);
        $model = new SiamRoleModel();
		$data = $model->getAll($page, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/SiamRole/delete
	 * @apiName delete
	 * @apiGroup /Api/SiamRole
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @Param(name="role_id", alias="用户id", optional="", lengthMax="11")
	 * @apiParam {int} role_id 主键id
	 * @apiSuccess {Number} code
	 * @apiSuccess {Object[]} data
	 * @apiSuccess {String} msg
	 * @apiSuccessExample {json} Success-Response:
	 * HTTP/1.1 200 OK
	 * {"code":200,"data":{},"msg":"success"}
	 * @author: AutomaticGeneration < 1067197739@qq.com >
     * @throws
	 */
	public function delete()
	{
		$param = $this->request()->getRequestParam();
		$model = new SiamRoleModel();

		$rs = $model->destroy(['role_id' => $param['role_id']]);
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, [], "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}

    protected function getValidateRule(?string $action): ?Validate
    {
        switch ($action){
            case 'save_tree_list':
                break;
        }
        return null;
    }
}

