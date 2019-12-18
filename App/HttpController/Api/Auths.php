<?php

namespace App\HttpController\Api;

use App\HttpController\Common\Menu;
use App\Model\System\SystemBean;
use App\Model\System\SystemModel;
use App\Model\Auths\AuthsBean;
use App\Model\Auths\AuthsModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;

/**
 * Class Auths
 * Create With Automatic Generator
 */
class Auths extends Base
{
	/**
	 * @api {get|post} /Api/Auths/add
	 * @apiName add
	 * @apiGroup /Api/Auths
	 * @apiPermission
	 * @apiDescription add新增数据
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
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new AuthsModel($db);
		$bean  = new AuthsBean();
		$bean->setAuthName($param['auth_name']);
		$bean->setAuthRules($param['auth_rules']);
		$bean->setAuthIcon($param['auth_icon']);
		$bean->setAuthType($param['auth_type']);
		$bean->setCreateTime(time());
		$bean->setUpdateTime(time());
		$rs = $model->add($bean);
		if ($rs) {
		    $bean->setAuthId($db->getInsertId());
            // 更新排序
            $system      = new SystemModel($db);
            $systemBean  = new SystemBean(['id' => 1]);
            $systeminfo  = $system->getOne($systemBean, 'auth_order');
            $authOrder   = json_decode($systeminfo->toArray()['auth_order'], TRUE);
            $authOrder[] = [
                'id' => $bean->getAuthId(),
            ];
            $system->update($systemBean, ['auth_order' => json_encode($authOrder)]);

		    $this->writeJson(Status::CODE_OK, $bean->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/Auths/update
	 * @apiName update
	 * @apiGroup /Api/Auths
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @apiParam {int} auth_id 主键id
	 * @apiParam {string} [auth_name] 权限名
	 * @apiParam {string} [auth_rules] 路由地址
	 * @apiParam {string} [auth_icon] 图标
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
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new AuthsModel($db);
		$bean = $model->getOne(new AuthsBean(['auth_id' => $param['auth_id']]));
		if (empty($bean)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateBean = new AuthsBean();

		$updateBean->setAuthName($param['auth_name']??$bean->getAuthName());
		$updateBean->setAuthRules($param['auth_rules']??$bean->getAuthRules());
		$updateBean->setAuthIcon($param['auth_icon']??$bean->getAuthIcon());
		$updateBean->setAuthType($param['auth_type']??$bean->getAuthType());
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
	 * @api {get|post} /Api/Auths/getOne
	 * @apiName getOne
	 * @apiGroup /Api/Auths
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
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
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new AuthsModel($db);
		$bean = $model->getOne(new AuthsBean(['auth_id' => $param['auth_id']]));
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/Auths/getAll
	 * @apiName getAll
	 * @apiGroup /Api/Auths
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
		$page = (int)($param['page']??1);
		$limit = (int)($param['limit']??20);
		$model = new AuthsModel($db);
		$data = $model->getAll($page, $param['keyword']??null, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/Auths/delete
	 * @apiName delete
	 * @apiGroup /Api/Auths
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
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
		$db = Mysql::defer('mysql');
		$param = $this->request()->getRequestParam();
		$model = new AuthsModel($db);

		$rs = $model->delete(new AuthsBean(['auth_id' => $param['auth_id']]));
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

    public function save_tree_list()
    {
        $request = $this->request();
        $order   = $request->getRequestParam('order');

        // 字符替换
        $order = str_replace('children', 'child', $order);

        $db = Mysql::defer('mysql');
        $systemModel = new SystemModel($db);
        $res = $systemModel->update(new SystemBean(['id' => 1]), ['auth_order' => $order]);

        if ($res){
            $this->writeJson(Status::CODE_OK, [], "SUCCESS");
            return true;
        }

        $this->writeJson(Status::CODE_INTERNAL_SERVER_ERROR, [], "ERROR");

    }
}

