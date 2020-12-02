<?php
declare(strict_types = 1);

use App\Handler\AbstractMigration;

final class Auth extends AbstractMigration
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
        $table = $this->table('auths', [
            'engine'  => 'InnoDb',
            'comment' => '权限表',
            'id'      => 'auth_id',
        ]);
        $table
            ->addColumn('auth_name', 'string', array ('limit' => 40, 'comment' => '权限名'))
            ->addColumn('auth_rules', 'string', array ('limit' => 40, 'comment' => '路由地址'))
            ->addColumn('auth_icon', 'string', array ('limit' => 40, 'comment' => '路由图标'))
            ->addColumn('auth_type', 'boolean', array ('limit' => 1, 'comment' => '权限类型 0菜单1按钮'))
            ->addColumn('create_time', 'integer', array ('default' => 0, 'comment' => '创建时间'))
            ->addColumn('update_time', 'integer', array ('default' => 0, 'comment' => '更新时间'))
            ->create();
        if ($this->isMigratingUp()) {
            $table->insert([
                [
                    'auth_name'   => "后台管理",
                    'auth_rules'  => "/admin/*/*",
                    'auth_icon'   => "layui-icon-rate-half",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "权限管理",
                    'auth_rules'  => "/auths/list",
                    'auth_icon'   => "layui-icon-set",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "角色管理",
                    'auth_rules'  => "/roles/list",
                    'auth_icon'   => "layui-icon-set",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "用户管理",
                    'auth_rules'  => "/user/list",
                    'auth_icon'   => "layui-icon-set",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "查看权限缓存",
                    'auth_rules'  => "/api/system/showCache",
                    'auth_icon'   => "layui-icon-template",
                    'auth_type'   => 3,
                    'create_time' => time(),
                    'update_time' => time(),
                ],[
                    'auth_name'   => "清空权限缓存",
                    'auth_rules'  => "/api/system/clearCache",
                    'auth_icon'   => "layui-icon-template",
                    'auth_type'   => 3,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "添加角色",
                    'auth_rules'  => "/api/roles/add",
                    'auth_icon'   => "layui-icon-template",
                    'auth_type'   => 3,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "前端模板说明",
                    'auth_rules'  => "/nepadmin/index",
                    'auth_icon'   => "layui-icon-question-circle",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
                [
                    'auth_name'   => "插件市场",
                    'auth_rules'  => "/plugs/index",
                    'auth_icon'   => "layui-icon-piechart",
                    'auth_type'   => 1,
                    'create_time' => time(),
                    'update_time' => time(),
                ],
            ])
            ->save();
        }
    }
}
