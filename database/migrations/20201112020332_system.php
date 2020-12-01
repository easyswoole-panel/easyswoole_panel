<?php
declare(strict_types = 1);

use App\Handler\AbstractMigration;

final class System extends AbstractMigration
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

        $table = $this->table('system', [
            'engine'  => 'InnoDb',
            'comment' => '系统表',
        ]);
        $table
            ->addColumn('user_next_id', 'integer', array ('limit' => 11, 'comment' => '下一个用户id'))
            ->addColumn('auth_order', 'string', array ('limit' => 300, 'comment' => '权限排序'))
            ->create();
        if ($this->isMigratingUp()) {
            $table->insert([
                [
                    'id'           => 1,
                    'user_next_id' => 1002,
                    'auth_order'   => '[{"id":1,"child":[{"id":2},{"id":3},{"id":4},{"id":9}]},{"id":8}]',
                ],
            ])
            ->save();
        }
    }
}
