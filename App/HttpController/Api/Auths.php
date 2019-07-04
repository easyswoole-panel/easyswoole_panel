<?php

namespace App\HttpController\Api;

use App\Model\System\SystemBean;
use App\Model\System\SystemModel;
use EasySwoole\MysqliPool\Mysql;
use App\Model\Auths\AuthsBean;
use App\Model\Auths\AuthsModel;
use EasySwoole\Http\Message\Status;

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
		$bean = new AuthsBean();
		$bean->setAuthName($param['auth_name']);
		$bean->setAuthRules($param['auth_rules']);
		$bean->setAuthIcon($param['auth_icon']);
		$bean->setAuthType($param['auth_type']);
		$bean->setCreateTime(time());
		$bean->setUpdateTime(time());
		$rs = $model->add($bean);
		if ($rs) {
		    $bean->setAuthId($db->getInsertId());
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
		$page = (int)$param['page']??1;
		$limit = (int)$param['limit']??20;
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

    protected function getValidateRule(?string $action): ?bool
    {
        // TODO: Implement getValidateRule() method.
        return true;
    }

    public function get_menu()
    {
        $str = <<<json
{
	"code": 0,
	"msg": "ok",
	"data": [{
		"title":"首页",
		"icon": "layui-icon-home",
		"href": "/"
	},{
		"title":"列表页",
		"icon": "layui-icon-unorderedlist",
		"childs":[{
			"title": "表格列表",
			"href":"/list/table/id=1"
		},{
			"title": "卡片列表",
			"href":"/list/card"
		}]
	},{
		"title":"详情页",
		"icon": "layui-icon-container",
		"childs":[{
			"title": "工作计划",
			"href":"/detail/plan"
		},{
      "title":"数据统计",
      "href": "/chart/index"
    }]
	},{
		"title":"表单页",
		"icon": "layui-icon-file-exception",
		"childs":[{
			"title": "表单元素",
			"href":"/form/basic"
		},{
			"title": "表单组合",
			"href":"/form/group"
		}]
	},{
		"title":"异常页",
		"icon": "layui-icon-error",
		"childs":[{
			"title": "403",
			"href":"/exception/403"
		},{
			"title": "404",
			"href":"/exception/404"
		},{
			"title": "500",
			"href":"/exception/500"
		}]
	},{
		"title": "新增模块",
		"icon": "layui-icon-experiment",
		"notice":3,
		"childs":[{
			"title": "admin",
			"href":"/module/admin"
		},{
			"title": "helper",
			"href":"/module/helper"
		},{
			"title": "loadBar",
			"href":"/module/loadbar"
		}]
	},{
		"title": "图标",
		"icon": "layui-icon-star",
		"href":"/icon/index"
	},{
		"title": "多级导航",
		"icon": "layui-icon-apartment",
		"childs":[{
			"title": "Dota2",
			"childs":[{
				"title": "敌法师",
				"childs":[{
					"title": "法力损毁"
				},{
					"title": "闪烁"
				},{
					"title": "法术护盾"
				},{
					"title": "法力虚空"
				}]
			},{
				"title": "帕吉",
				"childs":[{
					"title": "肉钩"
				},{
					"title": "腐烂"
				},{
					"title": "腐肉堆积"
				},{
					"title": "肢解"
				}]
			}]
		},{
			"title": "LOL",
			"childs":[]
		}]
	}]
}
json;
        $this->response()->write($str);
    }

    public function get_menu_new()
    {
        $onlyMenu = false;
        $db = Mysql::defer('mysql');
        $systemModel = new SystemModel($db);
        $systemInfo = $systemModel->getOne(new SystemBean(['id' => 1]));

        if ($systemInfo == null){

        }

        $order  = json_decode($systemInfo['auth_order'], TRUE);
        $return = $this->makeTree($order);

    }
    function makeTree($child)
    {
        $return = [];
        foreach ($child as $key => $value){
            // 未有权限
            if ( empty($this->auth_list[$value['id']] )){
                continue;
            }
            // 如果只需要获取菜单
            if (true == $this->onlyMenu){
                if ($this->auth_list[$value['id']]['auth_type'] == '1'){
                    continue;
                }
            }
            $tem = $this->auth_list[$value['id']];
            if ( isset($value['child']) ){
                $tem['child'] = $this->makeTree($value['child']);
            }
            $return[] = $tem;
        }
        return $return;
    }

}

