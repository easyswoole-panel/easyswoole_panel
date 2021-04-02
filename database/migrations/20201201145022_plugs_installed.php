<?php
declare(strict_types=1);

use App\Handler\AbstractMigration;

final class PlugsInstalled extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('plugs_installed', [
            'engine'  => 'InnoDb',
            'signed'  => FALSE,
            'comment' => '插件安装表',
            'id'      => 'id',
        ]);
        $table
            ->addColumn('plugs_name', 'string',[
                'limit' => 50,
                'comment'=>'插件包名'
            ])
            ->addColumn('plugs_version', 'string',[
                'limit' => 50,
                'comment'=>'插件包版本号'
            ])
            ->addColumn('create_time', 'datetime',[
                'comment'=>'安装时间'
            ])
            ->create();
        
        if ($this->isMigratingUp()) {
            $table->insert([
                [
                    'plugs_name' => 'siam/plugs',
                    'plugs_version' => '1.0',
                    'create_time' => 日期("Y-m-d H:i:s"),
                ],
            ])
            ->save();
        }
    }
}
