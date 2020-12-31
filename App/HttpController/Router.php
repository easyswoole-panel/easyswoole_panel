<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\AbstractRouter;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use FastRoute\RouteCollector;
use Siam\Plugs\PlugsInitialization;

class Router extends AbstractRouter
{
    function initialize(RouteCollector $routeCollector)
    {
        // 在这里调用 插件初始化系统到initRouter  [这个方法需要新增]s
        PlugsInitialization::initRouter($routeCollector);
    }
}