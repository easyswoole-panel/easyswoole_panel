<?php

namespace App\HttpController\Panel;

use App\Model\PlugsInstalledModel;
use EasySwoole\Component\Context\ContextManager;
use EasySwoole\HttpAnnotation\AnnotationController;
use EasySwoole\Http\Message\Status;

/**
 * SiamPlugsInstalled
 * Class SiamPlugsInstalled
 * Create With ClassGeneration
 * @ApiGroup(groupName="/Panel/PlugsInstalled.SiamPlugsInstalled")
 * @ApiGroupAuth(name="")
 * @ApiGroupDescription("")
 */
class PlugsInstalled extends AnnotationController
{
	/**
	 * @Api(name="add",path="/Panel/PlugsInstalled/SiamPlugsInstalled/add")
	 * @ApiDescription("新增数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="plugs_name",alias="插件包名",description="插件包名",lengthMax="50",required="")
	 * @Param(name="plugs_version",alias="插件包版本号",description="插件包版本号",lengthMax="50",required="")
	 * @Param(name="create_time",alias="安装时间",description="安装时间",required="")
	 */
	public function add()
	{
		$param = ContextManager::getInstance()->get('param');
		$data = [
		    'id'=>$param['id'],
		    'plugs_name'=>$param['plugs_name'],
		    'plugs_version'=>$param['plugs_version'],
		    'create_time'=>$param['create_time'],
		];
		$model = new PlugsInstalledModel($data);
		$model->save();
		$this->writeJson(Status::CODE_OK, $model->toArray(), "新增成功");
	}


	/**
	 * @Api(name="update",path="/Panel/PlugsInstalled/SiamPlugsInstalled/update")
	 * @ApiDescription("更新数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"更新成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"更新失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @Param(name="plugs_name",alias="插件包名",description="插件包名",lengthMax="50",optional="")
	 * @Param(name="plugs_version",alias="插件包版本号",description="插件包版本号",lengthMax="50",optional="")
	 * @Param(name="create_time",alias="安装时间",description="安装时间",optional="")
	 */
	public function update()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new PlugsInstalledModel();
		$info = $model->get(['id' => $param['id']]);
		if (empty($info)) {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '该数据不存在');
		    return false;
		}
		$updateData = [];

		$updateData['plugs_name']=$param['plugs_name'] ?? $info->plugs_name;
		$updateData['plugs_version']=$param['plugs_version'] ?? $info->plugs_version;
		$updateData['create_time']=$param['create_time'] ?? $info->create_time;
		$info->update($updateData);
		$this->writeJson(Status::CODE_OK, $info, "更新数据成功");
	}


	/**
	 * @Api(name="getOne",path="/Panel/PlugsInstalled/SiamPlugsInstalled/getOne")
	 * @ApiDescription("获取一条数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"获取成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"获取失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 * @ApiSuccessParam(name="result.id",description="")
	 * @ApiSuccessParam(name="result.plugs_name",description="插件包名")
	 * @ApiSuccessParam(name="result.plugs_version",description="插件包版本号")
	 * @ApiSuccessParam(name="result.create_time",description="安装时间")
	 */
	public function getOne()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new PlugsInstalledModel();
		$info = $model->get(['id' => $param['id']]);
		if ($info) {
		    $this->writeJson(Status::CODE_OK, $info, "获取数据成功.");
		} else {
		    $this->writeJson(Status::CODE_BAD_REQUEST, [], '数据不存在');
		}
	}


	/**
	 * @Api(name="getList",path="/Panel/PlugsInstalled/SiamPlugsInstalled/getList")
	 * @ApiDescription("获取数据列表")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"获取成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"获取失败"})
	 * @Param(name="page", from={GET,POST}, alias="页数", optional="")
	 * @Param(name="pageSize", from={GET,POST}, alias="每页总数", optional="")
	 * @ApiSuccessParam(name="result[].id",description="")
	 * @ApiSuccessParam(name="result[].plugs_name",description="插件包名")
	 * @ApiSuccessParam(name="result[].plugs_version",description="插件包版本号")
	 * @ApiSuccessParam(name="result[].create_time",description="安装时间")
	 */
	public function getList()
	{
		$param = ContextManager::getInstance()->get('param');
		$page = (int)($param['page'] ?? 1);
		$pageSize = (int)($param['pageSize'] ?? 20);
		$model = new PlugsInstalledModel();
		$data = $model->getList($page, $pageSize);
		$this->writeJson(Status::CODE_OK, $data, '获取列表成功');
	}


	/**
	 * @Api(name="delete",path="/Panel/PlugsInstalled/SiamPlugsInstalled/delete")
	 * @ApiDescription("删除数据")
	 * @Method(allow={GET,POST})
	 * @InjectParamsContext(key="param")
	 * @ApiSuccessParam(name="code",description="状态码")
	 * @ApiSuccessParam(name="result",description="api请求结果")
	 * @ApiSuccessParam(name="msg",description="api提示信息")
	 * @ApiSuccess({"code":200,"result":[],"msg":"新增成功"})
	 * @ApiFail({"code":400,"result":[],"msg":"新增失败"})
	 * @Param(name="id",lengthMax="11",required="")
	 */
	public function delete()
	{
		$param = ContextManager::getInstance()->get('param');
		$model = new PlugsInstalledModel();
		$info = $model->get(['id' => $param['id']]);
		if (!$info) {
		    $this->writeJson(Status::CODE_OK, $info, "数据不存在.");
		}

		$info->destroy();
		$this->writeJson(Status::CODE_OK, [], "删除成功.");
	}
}

