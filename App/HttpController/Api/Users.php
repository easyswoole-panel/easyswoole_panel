<?php

namespace App\HttpController\Api;

use App\Model\System\SiamSystemModel;
use App\Model\Users\SiamUserModel;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Http\Annotation\Param;
use EasySwoole\Http\Message\Status;
use EasySwoole\Jwt\Jwt;
use EasySwoole\Validate\Validate;

/**
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
     * @Param(name="u_id", alias="", required="", lengthMax="11")
     * @Param(name="u_password", alias="用户密码", required="", lengthMax="32")
     * @Param(name="u_name", alias="用户名", required="", lengthMax="32")
     * @Param(name="u_account", alias="用户登录名", required="", lengthMax="32")
     * @Param(name="p_u_id", alias="上级u_id", required="", lengthMax="10")
     * @Param(name="role_id", alias="", required="", lengthMax="255")
     * @Param(name="u_status", alias="用户状态 -1删除 0禁用 1正常", required="", lengthMax="1")
     * @Param(name="u_level_line", alias="用户层级链", required="", lengthMax="100")
     * @Param(name="last_login_ip", alias="最后登录IP", required="", lengthMax="20")
     * @Param(name="last_login_time", alias="最后登录时间", required="", lengthMax="11")
     * @Param(name="create_time", alias="创建时间", required="", lengthMax="11")
     * @Param(name="update_time", alias="更新时间", required="", lengthMax="11")
     * @Param(name="u_auth", alias="", required="", lengthMax="255")
     * @apiParam {int} u_id
     * @apiParam {string} u_password 用户密码
     * @apiParam {string} u_name 用户名
     * @apiParam {string} u_account 用户登录名
     * @apiParam {string} p_u_id 上级u_id
     * @apiParam {string} role_id
     * @apiParam {int} u_status 用户状态 -1删除 0禁用 1正常
     * @apiParam {string} u_level_line 用户层级链
     * @apiParam {string} last_login_ip 最后登录IP
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
     * @throws
     */
    public function add()
    {
        $param = $this->request()->getRequestParam();

        $systemModel = SiamSystemModel::create()->get();

        // 如果存在并发 则在后续再拼接随机内容当账号 建议1~2位数字
        $account = $systemModel->getNewAccount() ?? time();

        $pUserInfo = SiamUserModel::create()->get([
            'u_id' => $this->token['u_id'],
        ]);

        $data  = [
            'u_id'            => $param['u_id'],
            'u_password'      => $param['u_password'] ?? 'e10adc3949ba59abbe56e057f20f883e',
            'u_name'          => $param['u_name'] ?? '',
            'u_account'       => $param['u_account'],
            'p_u_id'          => $param['p_u_id'] ?? '',
            'role_id'         => $param['role_id'],
            'u_status'        => $param['u_status'] ?? '1',
            'u_level_line'    => $pUserInfo->u_level_line,
            'last_login_ip'   => $param['last_login_ip'] ?? '0',
            'last_login_time' => $param['last_login_time'] ?? '0',
            'create_time'     => $param['create_time'] ?? '0',
            'update_time'     => $param['update_time'] ?? '0',
            'u_auth'          => $param['u_auth'],
        ];
        $model = new SiamUserModel($data);
        $rs    = $model->save();
        if ($rs) {
            $this->writeJson(Status::CODE_OK, $model->toArray(), "success");
            // 更新层级链
            $model->u_level_line = $model->u_level_line."-".$model->u_id;
            $updateRes           = $model->update();
            if (!$updateRes) $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
            $this->writeJson(Status::CODE_OK, $model->toArray(), "success");
        } else {
            $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
        }
    }


    /**
     * @api {get|post} /Api/Users/update
     * @apiName update
     * @apiGroup /Api/Users
     * @apiPermission
     * @apiDescription update修改数据
     * @Param(name="u_id", alias="", optional="", lengthMax="11")
     * @Param(name="u_password", alias="用户密码", optional="", lengthMax="32")
     * @Param(name="u_name", alias="用户名", optional="", lengthMax="32")
     * @Param(name="u_account", alias="用户登录名", optional="", lengthMax="32")
     * @Param(name="p_u_id", alias="上级u_id", optional="", lengthMax="10")
     * @Param(name="role_id", alias="", optional="", lengthMax="255")
     * @Param(name="u_status", alias="用户状态 -1删除 0禁用 1正常", optional="", lengthMax="1")
     * @Param(name="u_level_line", alias="用户层级链", optional="", lengthMax="100")
     * @Param(name="last_login_ip", alias="最后登录IP", optional="", lengthMax="20")
     * @Param(name="last_login_time", alias="最后登录时间", optional="", lengthMax="11")
     * @Param(name="create_time", alias="创建时间", optional="", lengthMax="11")
     * @Param(name="update_time", alias="更新时间", optional="", lengthMax="11")
     * @Param(name="u_auth", alias="", optional="", lengthMax="255")
     * @apiParam {int} u_id 主键id
     * @apiParam {int} [u_id]
     * @apiParam {mixed} [u_password] 用户密码
     * @apiParam {mixed} [u_name] 用户名
     * @apiParam {mixed} [u_account] 用户登录名
     * @apiParam {mixed} [p_u_id] 上级u_id
     * @apiParam {mixed} [role_id]
     * @apiParam {int} [u_status] 用户状态 -1删除 0禁用 1正常
     * @apiParam {mixed} [u_level_line] 用户层级链
     * @apiParam {mixed} [last_login_ip] 最后登录IP
     * @apiParam {int} [last_login_time] 最后登录时间
     * @apiParam {int} [create_time] 创建时间
     * @apiParam {int} [update_time] 更新时间
     * @apiParam {mixed} [u_auth]
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
        $model = new SiamUserModel();
        $info  = $model->get(['u_id' => $param['u_id']]);
        if (empty($info)) {
            $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
            return FALSE;
        }
        $updateData = [];

        $updateData['u_id']            = $param['u_id'] ?? $info->u_id;
        $updateData['u_password']      = $param['u_password'] ?? $info->u_password;
        $updateData['u_name']          = $param['u_name'] ?? $info->u_name;
        $updateData['u_account']       = $param['u_account'] ?? $info->u_account;
        $updateData['p_u_id']          = $param['p_u_id'] ?? $info->p_u_id;
        $updateData['role_id']         = $param['role_id'] ?? $info->role_id;
        $updateData['u_status']        = $param['u_status'] ?? $info->u_status;
        $updateData['u_level_line']    = $param['u_level_line'] ?? $info->u_level_line;
        $updateData['last_login_ip']   = $param['last_login_ip'] ?? $info->last_login_ip;
        $updateData['last_login_time'] = $param['last_login_time'] ?? $info->last_login_time;
        $updateData['create_time']     = $param['create_time'] ?? $info->create_time;
        $updateData['update_time']     = $param['update_time'] ?? $info->update_time;
        $updateData['u_auth']          = $param['u_auth'] ?? $info->u_auth;

        $rs = $info->update($updateData);
        if ($rs) {
            $this->writeJson(Status::CODE_OK, $rs, "success");
        } else {
            $this->writeJson(Status::CODE_BAD_REQUEST, [], $model->lastQueryResult()->getLastError());
        }
    }


    /**
     * @api {get|post} /Api/Users/getOne
     * @apiName getOne
     * @apiGroup /Api/Users
     * @apiPermission
     * @apiDescription 根据主键获取一条信息
     * @Param(name="u_id", alias="", optional="", lengthMax="11")
     * @apiParam {int} u_id 主键id
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
        $model = new SiamUserModel();
        $bean  = $model->get(['u_id' => $param['u_id']]);
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
     * @throws
     */
    public function getAll()
    {
        $param = $this->request()->getRequestParam();
        $page  = (int) ($param['page'] ?? 1);
        $limit = (int) ($param['limit'] ?? 20);
        $model = new SiamUserModel();
        if (isset($param['keyword'])){
            $model->where('u_name', "%{$param['keyword']}%", 'like');
        }
        $data  = $model->getAll($page, $limit);
        $this->writeJson(Status::CODE_OK, $data, 'success');
    }


    /**
     * @api {get|post} /Api/Users/delete
     * @apiName delete
     * @apiGroup /Api/Users
     * @apiPermission
     * @apiDescription 根据主键删除一条信息
     * @Param(name="u_id", alias="", optional="", lengthMax="11")
     * @apiParam {int} u_id 主键id
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
        $model = new SiamUserModel();

        $rs = $model->destroy(['u_id' => $param['u_id']]);
        if ($rs) {
            $this->writeJson(Status::CODE_OK, [], "success");
        } else {
            $this->writeJson(Status::CODE_BAD_REQUEST, [], 'fail');
        }
    }

    protected function getValidateRule(?string $action): ?Validate
    {
        // TODO: Implement getValidateRule() method.
        switch ($action) {
            case 'login':
                $valitor = new Validate();
                $valitor->addColumn('u_account')->required();
                $valitor->addColumn('u_password')->required();
                return $valitor;
                break;
        }
        return NULL;
    }

    /**
     * @return bool
     * @throws \EasySwoole\Mysqli\Exception\Exception
     * @throws \EasySwoole\ORM\Exception\Exception
     * @throws \Throwable
     */
    public function login()
    {
        $user = SiamUserModel::create()->get([
            'u_account' => $this->request()->getRequestParam('u_account'),
        ]);

        if ($user === NULL) {
            $this->writeJson(Status::CODE_NOT_FOUND, new \stdClass(), '用户不存在');
            return FALSE;
        }


        // 生成token
        $config    = Config::getInstance();
        $jwtConfig = $config->getConf('JWT');

        $jwtObject = Jwt::getInstance()
            ->setSecretKey($jwtConfig['key']) // 秘钥
            ->publish();

        $jwtObject->setAlg('HMACSHA256'); // 加密方式
        $jwtObject->setAud("easy_swoole_admin"); // 用户
        $jwtObject->setExp(time()+$jwtConfig['exp']); // 过期时间
        $jwtObject->setIat(time()); // 发布时间
        $jwtObject->setIss($jwtConfig['iss']); // 发行人
        $jwtObject->setJti(md5(time())); // jwt id 用于标识该jwt
        $jwtObject->setNbf(time()); // 在此之前不可用
        $jwtObject->setSub($jwtConfig['sub']); // 主题

        // 自定义数据
        $jwtObject->setData([
            'u_id'   => $user->u_id,
            'u_name' => $user->u_name
        ]);

        // 最终生成的token
        $token = $jwtObject->__toString();

        $this->writeJson(Status::CODE_OK, [
            'token'    => $token,
            'userInfo' => $user->toArray(),
            'authList' => $user->getAuth(),
        ], '登陆成功');
    }
}

