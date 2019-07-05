<?php

namespace App\HttpController\Api;

use App\Model\Auths\AuthsBean;
use App\Model\Auths\AuthsModel;
use App\Model\Users\UsersModel;
use EasySwoole\FastCache\Cache;
use EasySwoole\MysqliPool\Mysql;
use EasySwoole\Policy\Policy;
use EasySwoole\Policy\PolicyNode;
use EasySwoole\Validate\Validate;
use Siam\JWT;

/**
 * BaseController
 * Class Base
 * Create With Automatic Generator
 */
abstract class Base extends \EasySwoole\Http\AbstractInterface\Controller
{
    private $basicAction = [
        '/api/users/login',
    ];
    protected $token;

    public function index()
	{
		$this->actionNotFound('index');
	}


	public function onRequest(?string $action): ?bool
	{
		if (!parent::onRequest($action)) {
		    return false;
		};

        $path = $this->request()->getUri()->getPath();

        // basic列表里的不需要验证
        if (!in_array($path, $this->basicAction)){
            // 必须有token
            if (empty( $this->request()->getHeader('token')[0] )){
                $this->writeJson(\EasySwoole\Http\Message\Status::CODE_BAD_REQUEST, new \stdClass(), "token不可为空");
                return false;
            }
            $this->token = JWT::getInstance()->setSecretKey(\EasySwoole\EasySwoole\Config::getInstance()->getConf('JWT.key'))->decode($this->request()->getHeader('token')[0]);
            if (!is_array($this->token) || empty($this->token)){
                $this->writeJson(\EasySwoole\Http\Message\Status::CODE_BAD_REQUEST, new \stdClass(), "token解析失败:".$this->token);
                return false;
            }
            // 权限策略判断
            if ( !$this->vifPolicy($this->token['u_id'], $path) ){
                $this->writeJson(\EasySwoole\Http\Message\Status::CODE_BAD_REQUEST, new \stdClass(), "无权限访问该接口");
                return false;
            }
        }

		// 各个action的参数校验
		$v = $this->getValidateRule($action);
		if ($v && !$this->validate($v)) {
		    $this->writeJson(\EasySwoole\Http\Message\Status::CODE_BAD_REQUEST, ['errorCode' => 1, 'data' => []], $v->getError()->__toString());
		    return false;
		}

		return true;
	}

	public function writeJson($statusCode = 200, $result = NULL, $msg = NULL)
    {
        if (!$this->response()->isEndResponse()) {
            $data = Array(
                "code" => $statusCode,
                "result" => $result,
                "msg" => $msg
            );
            $this->response()->write(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            $this->response()->withHeader('Content-type', 'application/json;charset=utf-8');
            $this->response()->withStatus(200);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证权限策略
     * @param $u_id
     * @param string $path
     * @return bool
     */
    private function vifPolicy($u_id, string $path)
    {
        if (empty($u_id)) return false;
        // 该路径接口不需要验证 直接通过
        if ($this->shouldVifPath($path) == false){
            return true;
        }
        // 从缓存拿 没有就从数据库读取 初始化
        $policy = Cache::getInstance()->get('policy_'.$u_id);
        if($policy === null){
            $policy = new Policy();
            // 用户权限
            $userModel = new UsersModel(Mysql::defer('mysql'));
            $userAuth  = $userModel->getAuth($u_id);
            foreach ($userAuth as $key => $value) {
                $policy->addPath($value['auth_rules'],PolicyNode::EFFECT_ALLOW);
            }
            Cache::getInstance()->set('policy_'.$u_id, serialize($policy), 10 * 60);
        }else{
            $policy = unserialize($policy);
        }

        if($policy->check($path) === 'allow'){
            return true;
        }
        return false;
    }

    /**
     * 该路径是否建立了权限管理  没建立就是不用管
     * @param string $path
     * @return bool
     */
    private function shouldVifPath(string $path): bool
    {
        $cache = Cache::getInstance();
        $authRes = $cache->get('shouldvif_api_'.md5($path));
        if ($authRes === null){
            echo "权限没有缓存 需要查询\n";
            $authModel = new AuthsModel(Mysql::defer('mysql'));
            $auth = $authModel->getOneByRules(new AuthsBean(['auth_rules' => $path]));
            if ($auth===null){
                $cache->set('shouldvif_api_'.md5($path),  false, 3*60);
                return false;
            }else{
                $cache->set('shouldvif_api_'.md5($path),  true, 3*60);
                return true;
            }
        }
        if ($authRes === true){
            return true;
        }
        return false;
    }

    abstract protected function getValidateRule(?string $action): ?Validate;
}

