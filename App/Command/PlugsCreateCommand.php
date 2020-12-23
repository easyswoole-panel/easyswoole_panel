<?php
namespace App\Command;

use EasySwoole\Command\AbstractInterface\CommandHelpInterface;
use EasySwoole\Command\CommandManager;
use EasySwoole\EasySwoole\Command\CommandInterface;
use EasySwoole\Utility\File;

class PlugsCreateCommand implements CommandInterface
{
    public function commandName(): string
    {
        return "create_plugs";
    }

    public function exec(): ?string
    {
        $plugsName = CommandManager::getInstance()->getArg(0);
        // test: 把plugsName 固定一下
        if (false !== strstr("/", $plugsName)) return "错误，名称需要 a/b";

        list ($packName, $plugsName) = explode("/", $plugsName);
        // 放到Addons中
        $path = EASYSWOOLE_ROOT."/Addons/{$packName}/$plugsName";
        // 把defaultFile的所有东西copy 到目标目录即可
        File::copyDirectory(__DIR__."/defaultFile/", $path);

        return "Create Finish! Your Plug Path : ". $path;
    }

    public function help(CommandHelpInterface $commandHelp): CommandHelpInterface
    {
        return $commandHelp->addAction("create_plugs", "创建新插件");
    }

    public function desc(): string
    {
        return "创建新插件";
    }
}