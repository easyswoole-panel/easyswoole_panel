<?php
/**
 * Created by PhpStorm.
 * Users: Siam
 * Date: 2019/7/2
 * Time: 17:28
 */

namespace App\HttpController;


use App\Model\Users\UsersBean;
use EasySwoole\FastCache\Cache;
use EasySwoole\Http\AbstractInterface\Controller;

class Index  extends Controller
{

    function index()
    {
        Cache::getInstance()->set('test_siam', new UsersBean(['u_id' => 1]));

        var_dump(Cache::getInstance()->get('test_siam'));
        // TODO: Implement index() method.
        // $db = \EasySwoole\MysqliPool\Mysql::defer('mysql');
        //
        // $mysqlTable = new \AutomaticGeneration\MysqlTable($db, \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.database'));
        // $tableName = 'siam_system';
        // $tableColumns = $mysqlTable->getColumnList($tableName);
        // $tableComment = $mysqlTable->getComment($tableName);
        //
        // $path = 'System';
        // $tableName = "siam_system";
        //
        // $beanConfig = new \AutomaticGeneration\Config\BeanConfig();
        // $beanConfig->setBaseNamespace("App\\Model\\".$path);
        // //    $beanConfig->setBaseDirectory(EASYSWOOLE_ROOT . '/' .\AutomaticGeneration\AppLogic::getAppPath() . 'Model');
        // $beanConfig->setTablePre("siam_");
        // $beanConfig->setTableName($tableName);
        // $beanConfig->setTableComment($tableComment);
        // $beanConfig->setTableColumns($tableColumns);
        // $beanBuilder = new \AutomaticGeneration\BeanBuilder($beanConfig);
        // $result = $beanBuilder->generateBean();
        //
        // $modelConfig = new \AutomaticGeneration\Config\ModelConfig();
        // $modelConfig->setBaseNamespace("App\\Model\\".$path);
        // //    $modelConfig->setBaseDirectory(EASYSWOOLE_ROOT . '/' .\AutomaticGeneration\AppLogic::getAppPath() . 'Model');
        // $modelConfig->setTablePre("siam_");
        // $modelConfig->setExtendClass(\App\Model\BaseModel::class);
        // $modelConfig->setTableName($tableName);
        // $modelConfig->setTableComment($tableComment);
        // $modelConfig->setTableColumns($tableColumns);
        // $modelBuilder = new \AutomaticGeneration\ModelBuilder($modelConfig);
        // $result = $modelBuilder->generateModel();
        //
        // $path='Api';
        // $controllerConfig = new \AutomaticGeneration\Config\ControllerConfig();
        // $controllerConfig->setBaseNamespace("App\\HttpController\\".$path);
        // //    $controllerConfig->setBaseDirectory( EASYSWOOLE_ROOT . '/' . $automatic::APP_PATH . '/HttpController/Api/');
        // $controllerConfig->setTablePre("siam_");
        // $controllerConfig->setTableName($tableName);
        // $controllerConfig->setTableComment($tableComment);
        // $controllerConfig->setTableColumns($tableColumns);
        // $controllerConfig->setExtendClass("App\\HttpController\\".$path."\\Base");
        // $controllerConfig->setModelClass($modelBuilder->getClassName());
        // $controllerConfig->setBeanClass($beanBuilder->getClassName());
        // $controllerConfig->setMysqlPoolClass(EasySwoole\MysqliPool\Mysql::class);
        // $controllerConfig->setMysqlPoolName('mysql');
        // $controllerBuilder = new \AutomaticGeneration\ControllerBuilder($controllerConfig);
        // $result = $controllerBuilder->generateController();
        $this->response()->write("123");
    }
}