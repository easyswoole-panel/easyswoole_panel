<?php

namespace App\HttpController\Api;

/**
 * BaseController
 * Class Base
 * Create With Automatic Generator
 */
abstract class Base extends \EasySwoole\Http\AbstractInterface\Controller
{
	public function index()
	{
		$this->actionNotFound('index');
	}


	public function onRequest(?string $action): ?bool
	{
		if (!parent::onRequest($action)) {
		    return false;
		};
		/*
		* 各个action的参数校验
		*/
		$v = $this->getValidateRule($action);
		// if ($v && !$this->validate($v)) {
		//     $this->writeJson(\EasySwoole\Http\Message\Status::CODE_BAD_REQUEST, ['errorCode' => 1, 'data' => []], $v->getError()->__toString());
		//     return false;
		// }
		return true;
	}


	abstract protected function getValidateRule(?string $action): ?bool;
}

