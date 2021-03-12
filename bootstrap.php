<?php
//全局bootstrap事件
date_default_timezone_set('Asia/Shanghai');
//插件项目创建命令
\EasySwoole\Command\CommandManager::getInstance()->addCommand(new Chrisplugs\CreatePlugsScript\PlugsCreateCommand());
