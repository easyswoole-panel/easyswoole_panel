<?php
declare(strict_types=1);

use App\Handler\AbstractMigration;

final class User extends AbstractMigration
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
        $table = $this->table('users', [
            'engine'  => 'InnoDb',
            'signed'  => FALSE,
            'comment' => '用户表',
            'id'      => 'u_id',
        ]);
        $table
            ->addColumn('u_name', 'string',array('limit' => 32,'default'=>'','comment'=>'用户名'))
            ->addColumn('u_account', 'string',array('limit' => 32,'comment'=>'用户登录名'))
            ->addColumn('u_password', 'string',array('limit' => 32,'default'=>md5('123456'),'comment'=>'用户密码'))
            ->addColumn('p_u_id', 'string',array('limit' => 10,'default'=>'','comment'=>'上级u_id'))
            ->addColumn('role_id', 'integer',array('limit' => 10,'default'=>0,'comment'=>'角色id'))
            ->addColumn('u_status', 'boolean',array('limit' => 1,'default'=>1,'comment'=>'用户状态 -1删除 0禁用 1正常'))
            ->addColumn('u_level_line', 'string',array('limit' => 100,'default'=>'0-','comment'=>'用户层级链'))
            ->addColumn('u_auth', 'string',['limit' => 255,'comment' => '独立权限'])
            ->addColumn('last_login_ip', 'integer',array('limit' => 11,'default'=>0,'comment'=>'最后登录IP'))
            ->addColumn('last_login_time', 'integer',array('default'=>0,'comment'=>'最后登录时间'))
            ->addColumn('create_time', 'integer',array('default'=>0,'comment'=>'创建时间'))
            ->addColumn('update_time', 'integer',array('default'=>0,'comment'=>'更新时间'))
            ->addIndex(array('u_id'), array('unique' => true))
            ->create();

        if ($this->isMigratingUp()) {
            $table->insert([
                [
                    "u_name"          => "Admin",
                    "u_account"       => "1001",
                    "u_password"      => "e10adc3949ba59abbe56e057f20f883e",
                    "p_u_id"          => "0",
                    "role_id"         => "1",
                    "u_status"        => "1",
                    "u_level_line"    => "0-1",
                    "last_login_ip"   => "0",
                    "u_auth"          => "",
                    "last_login_time" => "0",
                    'create_time'     => time(),
                    'update_time'     => time(),
                ],
            ])
            ->save();
        }
    }
}
