<?php

namespace App\HttpController\Api;

use App\HttpController\Common\Menu;
use App\Model\Auths\SiamAuthModel;
use App\Model\System\SiamSystemModel;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Class SiamAuth
 * Create With Automatic Generator
 */
class Auths extends Base
{
	/**
	 * @api {get|post} /Api/SiamAuth/add
	 * @apiName add
	 * @apiGroup /Api/SiamAuth* @apiPermission
	 * @apiDescription add新增数据
	 * @Param(name="auth_id", alias="权限id", required="", lengthMax="11")
	 * @Param(name="auth_name", alias="权限名", required="", lengthMax="40")
	 * @Param(name="auth_rules", alias="路由地址", required="", lengthMax="40")
	 * @Param(name="auth_icon", alias="图标", required="", lengthMax="30")
	 * @Param(name="auth_type", alias="权限类型 0菜单1按钮", required="", lengthMax="1")
	 * @Param(name="create_time", alias="创建时间", required="", lengthMax="11")
	 * @Param(name="update_time", alias="更新时间", required="", lengthMax="11")
	 * @apiParam {int} auth_id 权限id
	 * @apiParam {string} auth_name 权限名
	 * @apiParam {string} auth_rules 路由地址
	 * @apiParam {string} auth_icon 图标
	 * @apiParam {int} auth_type 权限类型 0菜单1按钮
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
        $param = $this->request()->getRequestParam();
        $data  = [
            'auth_name'   => $param['auth_name'],
            'auth_rules'  => $param['auth_rules'] ?? '0',
            'auth_icon'   => $param['auth_icon'] ?? '',
            'auth_type'   => $param['auth_type'] ?? '0',
            'create_time' => $param['create_time'] ?? '0',
            'update_time' => $param['update_time'] ?? '0',
		];
		$model = new SiamAuthModel($data);
		$rs = $model->save();
		if ($rs) {
		    // 更新到排序中
            $system = SiamSystemModel::create()->get();
            $auth = json_decode($system->auth_order);
            $auth[] = ['id'=>$model->auth_id];
            $system->auth_order = json_encode($auth);
            $system->update();
		    $this->writeJson(Status::CODE_OK, $model->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/SiamAuth/update
	 * @apiName update
	 * @apiGroup /Api/SiamAuth
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @Param(name="auth_id", alias="权限id", optional="", lengthMax="11")
	 * @Param(name="auth_name", alias="权限名", optional="", lengthMax="40")
	 * @Param(name="auth_rules", alias="路由地址", optional="", lengthMax="40")
	 * @Param(name="auth_icon", alias="图标", optional="", lengthMax="30")
	 * @Param(name="auth_type", alias="权限类型 0菜单1按钮", optional="", lengthMax="1")
	 * @Param(name="create_time", alias="创建时间", optional="", lengthMax="11")
	 * @Param(name="update_time", alias="更新时间", optional="", lengthMax="11")
	 * @apiParam {int} auth_id 主键id
	 * @apiParam {int} [auth_id] 权限id
	 * @apiParam {mixed} [auth_name] 权限名
	 * @apiParam {mixed} [auth_rules] 路由地址
	 * @apiParam {mixed} [auth_icon] 图标
	 * @apiParam {int} [auth_type] 权限类型 0菜单1按钮
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
		$param = $this->request()->getRequestParam();
		$model = new SiamAuthModel();
		$info = $model->get(['auth_id' => $param['auth_id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['auth_id'] = $param['auth_id']??$info->auth_id;
		$updateData['auth_name'] = $param['auth_name']??$info->auth_name;
		$updateData['auth_rules'] = $param['auth_rules']??$info->auth_rules;
		$updateData['auth_icon'] = $param['auth_icon']??$info->auth_icon;
		$updateData['auth_type'] = $param['auth_type']??$info->auth_type;
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
	 * @api {get|post} /Api/SiamAuth/getOne
	 * @apiName getOne
	 * @apiGroup /Api/SiamAuth
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @Param(name="auth_id", alias="权限id", optional="", lengthMax="11")
	 * @apiParam {int} auth_id 主键id
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
		$model = new SiamAuthModel();
		$bean = $model->get(['auth_id' => $param['auth_id']]);
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/SiamAuth/getAll
	 * @apiName getAll
	 * @apiGroup /Api/SiamAuth
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
		$model = new SiamAuthModel();
		$data = $model->getAll($page,  $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/SiamAuth/delete
	 * @apiName delete
	 * @apiGroup /Api/SiamAuth
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @Param(name="auth_id", alias="权限id", optional="", lengthMax="11")
	 * @apiParam {int} auth_id 主键id
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
		$model = new SiamAuthModel();

		$rs = $model->destroy(['auth_id' => $param['auth_id']]);
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
                $valitor = new Validate();
                $valitor->addColumn('order')->required();
                return $valitor;
                break;
        }
        return null;
    }

    public function get_menu()
    {
        $menu = new Menu();
        $menu->setOnlyMenu(true);
        $tree = $menu->get($this->token['u_id']);
        array_unshift($tree, ['auth_rules'=>'/', 'auth_name' => '首页', 'auth_icon' => 'layui-icon-home']);
        $this->writeJson(Status::CODE_OK, $tree, "success");
    }

    public function get_tree_list()
    {
        // 只有管理员能调用
        $menu = new Menu();
        $menu->setOnlyMenu(false);
        $tree = $menu->get(1);
        $this->writeJson(Status::CODE_OK, $tree, "success");
    }

    /**
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function save_tree_list()
    {
        $request = $this->request();
        $order   = $request->getRequestParam('order');

        // 字符替换
        $order = str_replace('children', 'child', $order);

        $systemModel = SiamSystemModel::create()->get();
        $systemModel->auth_order = $order;
        $res = $systemModel->update();

        if ($res){
            $this->writeJson(Status::CODE_OK, [], "SUCCESS");
            return true;
        }

        $this->writeJson(Status::CODE_INTERNAL_SERVER_ERROR, [], "ERROR");

    }
}

