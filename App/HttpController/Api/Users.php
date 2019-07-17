<?php

namespace App\HttpController\Api;

use App\Model\System\SystemBean;
use App\Model\System\SystemModel;
use EasySwoole\EasySwoole\Config;
use EasySwoole\MysqliPool\Mysql;
use App\Model\Users\UsersBean;
use App\Model\Users\UsersModel;
use EasySwoole\Http\Message\Status;
use EasySwoole\Validate\Validate;
use Siam\JWT;

/**
 * 用户表
 * Class Users
 * Create With Automatic Generator
 */
class Users extends Base
{
	/**
	 * @api {get|post} /Api/Users/add
	 * @apiName add
	 * @apiGroup /Api/Users
	 * @apiPermission
	 * @apiDescription add新增数据
	 * @apiParam {string} u_password 用户密码
	 * @apiParam {string} u_name 用户名
	 * @apiParam {string} u_account 用户登录名
	 * @apiParam {string} p_u_id 上级u_id
	 * @apiParam {string} role_id
	 * @apiParam {int} u_status 用户状态 -1删除 0禁用 1正常
	 * @apiParam {string} u_level_line 用户层级链
	 * @apiParam {int} last_login_ip 最后登录IP
	 * @apiParam {int} last_login_time 最后登录时间
	 * @apiParam {int} create_time 创建时间
	 * @apiParam {int} update_time 更新时间
	 * @apiParam {string} u_auth
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
        $db    = Mysql::defer('mysql');
        $param = $this->request()->getRequestParam();
        $model = new UsersModel($db);
        $bean  = new UsersBean();

        $systemModel = new SystemModel($db);

        // 如果存在并发 则在后续再拼接随机内容当账号 建议1~2位数字
        $account = $systemModel->getNewAccount() ?? time();

        $pUserInfo = $model->getOne(new UsersBean(['u_id' =>$this->token['u_id']]));

		$bean->setUPassword($param['u_password']);
		$bean->setUName($param['u_name']);
		$bean->setUAccount($account);
		$bean->setPUId($this->token['u_id']);
		$bean->setRoleId($param['role_id']);
		$bean->setUStatus(1);
		$bean->setULevelLine($pUserInfo->getULevelLine());
		$bean->setLastLoginIp($param['last_login_ip'] ?? '');
		$bean->setLastLoginTime($param['last_login_time'] ?? time());
		$bean->setCreateTime(time());
		$bean->setUpdateTime(time());
		$bean->setUAuth($param['u_auth'] ?? '');

		$rs = $model->add($bean);

		if ($rs) {
		    $bean->setUId($db->getInsertId());
		    // 更新层级链
            $updateRes = $model->update($bean, ['u_level_line' => $bean->getULevelLine()."-". $bean->getUId()]);
            if (!$updateRes) $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		    $this->writeJson(Status::CODE_OK, $bean->toArray(), "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/Users/update
	 * @apiName update
	 * @apiGroup /Api/Users
	 * @apiPermission
	 * @apiDescription update修改数据
	 * @apiParam {int} u_id 主键id
	 * @apiParam {string} [u_password] 用户密码
	 * @apiParam {string} [u_name] 用户名
	 * @apiParam {string} [u_account] 用户登录名
	 * @apiParam {string} [p_u_id] 上级u_id
	 * @apiParam {string} [role_id]
	 * @apiParam {int} [u_status] 用户状态 -1删除 0禁用 1正常
	 * @apiParam {string} [u_level_line] 用户层级链
	 * @apiParam {int} [last_login_ip] 最后登录IP
	 * @apiParam {int} [last_login_time] 最后登录时间
	 * @apiParam {int} [create_time] 创建时间
	 * @apiParam {int} [update_time] 更新时间
	 * @apiParam {string} [u_auth]
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
		$model = new UsersModel($db);
		$bean = $model->getOne(new UsersBean(['u_id' => $param['u_id']]));
		if (empty($bean)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateBean = new UsersBean();

		$updateBean->setUPassword($param['u_password']??$bean->getUPassword());
		$updateBean->setUName($param['u_name']??$bean->getUName());
		$updateBean->setUAccount($param['u_account']??$bean->getUAccount());
		$updateBean->setPUId($param['p_u_id']??$bean->getPUId());
		$updateBean->setRoleId($param['role_id']??$bean->getRoleId());
		$updateBean->setUStatus($param['u_status']??$bean->getUStatus());
		$updateBean->setULevelLine($param['u_level_line']??$bean->getULevelLine());
		$updateBean->setLastLoginIp($param['last_login_ip']??$bean->getLastLoginIp());
		$updateBean->setLastLoginTime($param['last_login_time']??$bean->getLastLoginTime());
		$updateBean->setCreateTime($param['create_time']??$bean->getCreateTime());
		$updateBean->setUpdateTime($param['update_time']??$bean->getUpdateTime());
		$updateBean->setUAuth($param['u_auth']??$bean->getUAuth());
		$rs = $model->update($bean, $updateBean->toArray([], $updateBean::FILTER_NOT_EMPTY));
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, $rs, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], $db->getLastError());
		}
	}


	/**
	 * @api {get|post} /Api/Users/getOne
	 * @apiName getOne
	 * @apiGroup /Api/Users
	 * @apiPermission
	 * @apiDescription 根据主键获取一条信息
	 * @apiParam {int} u_id 主键id
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
		$model = new UsersModel($db);
		$bean = $model->getOne(new UsersBean(['u_id' => $param['u_id']]));
		if ($bean) {
		    $this->writeJson(Status::CODE_OK, $bean, "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}


	/**
	 * @api {get|post} /Api/Users/getAll
	 * @apiName getAll
	 * @apiGroup /Api/Users
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
		$page = ((int)$param['page'])??1;
		$limit = ((int)$param['limit'])??20;
		$model = new UsersModel($db);
		$data = $model->getAll($page, $param['keyword']??null, $limit);
		$this->writeJson(Status::CODE_OK, $data, 'success');
	}


	/**
	 * @api {get|post} /Api/Users/delete
	 * @apiName delete
	 * @apiGroup /Api/Users
	 * @apiPermission
	 * @apiDescription 根据主键删除一条信息
	 * @apiParam {int} u_id 主键id
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
		$model = new UsersModel($db);

		$rs = $model->delete(new UsersBean(['u_id' => $param['u_id']]));
		if ($rs) {
		    $this->writeJson(Status::CODE_OK, [], "success");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
		}
	}

    protected function getValidateRule(?string $action): ?Validate
    {
        // TODO: Implement getValidateRule() method.
        switch ($action){
            case 'login':
                $valitor = new Validate();
                $valitor->addColumn('u_account')->required();
                $valitor->addColumn('u_password')->required();
                return $valitor;
                break;
        }
        return null;
    }

    public function login()
    {
        $db = Mysql::defer('mysql');
        $userModel = new UsersModel($db);
        $userBean  = new UsersBean([
            'u_account' => $this->request()->getRequestParam('u_account')
        ]);

        $user = $userModel->getOneByAccount($userBean);

        if ($user === null){
            $this->writeJson(Status::CODE_NOT_FOUND, new \stdClass(), '用户不存在');
            return false;
        }


        // 生成token
        $config = Config::getInstance();
        $jwtConfig = $config->getConf('JWT');
        $token = JWT::getInstance()->setSub($jwtConfig['sub'])
            ->setIss($jwtConfig['iss'])
            ->setExp($jwtConfig['exp'])
            ->setSecretKey($jwtConfig['key'])
            ->setNbf(($jwtConfig['nbf'] !== null) ? time() + $jwtConfig['nbf'] : time())
            ->setWith([
                'u_id' => $user->getUId(),
                'u_name' => $user->getUName(),
            ])
            ->make();

        $this->writeJson(Status::CODE_OK, [
            'token'    => $token,
            'userInfo' => $user->toArray(),
            'authList' => $userModel->getAuth($user->getUId()),
        ], '登陆成功');
    }
}

