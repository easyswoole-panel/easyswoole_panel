<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2020/12/1 0001
 * Time: 21:52
 */

namespace App\Handler;


class AbstractMigration extends \Phinx\Migration\AbstractMigration
{
    public function table($tableName, $options = [])
    {
        return parent::table(PHINX_PRE.$tableName, $options);
    }
}