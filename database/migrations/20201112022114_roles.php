<?php
declare(strict_types = 1);

use App\Handler\AbstractMigration;

final class Roles extends AbstractMigration
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
        $table = $this->table('roles', [
            'engine'  => 'InnoDb',
            'comment' => '角色表',
            'id'      => 'role_id',
        ]);
        $table
            ->addColumn('role_name', 'string', array ('limit' => 40, 'comment' => '角色名'))
            ->addColumn('role_auth', 'string', array ('limit' => 255, 'default' => 0, 'comment' => '角色权限'))
            ->addColumn('role_status', 'boolean', array ('limit' => 1, 'default' => 0, 'comment' => '角色状态 0正常1禁用'))
            ->addColumn('level', 'boolean', array ('limit' => 1, 'default' => 0, 'comment' => '角色级别 越小权限越高'))
            ->addColumn('create_time', 'integer', array ('default' => 0, 'comment' => '创建时间'))
            ->addColumn('update_time', 'integer', array ('default' => 0, 'comment' => '更新时间'))
            ->create();

        if ($this->isMigratingUp()) {
            $table->insert([
                [
                    'role_name'   => "管理员",
                    'role_auth'   => "1,2,3,4",
                    'role_status' => 0,
                    'level'       => 0,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
            ])
                ->save();
        }
    }
}
