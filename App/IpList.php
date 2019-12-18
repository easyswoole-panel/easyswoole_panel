<?php
/**
 * Created by PhpStorm.
 * Users: Siam
 * Date: 2019/7/8 0008
 * Time: 下午 9:53
 */

namespace App;


use EasySwoole\Component\Singleton;
use EasySwoole\Component\TableManager;
use Swoole\Table;

class IpList
{
    use Singleton;

    /** @var Table */
    protected $table;

    public  function __construct()
    {
        TableManager::getInstance()->add('ipList', [
            'ip' => [
                'type' => Table::TYPE_STRING,
                'size' => 16
            ],
            'count' => [
                'type' => Table::TYPE_INT,
                'size' => 8
            ],
            'lastAccessTime' => [
                'type' => Table::TYPE_INT,
                'size' => 8
            ]
        ], 1024*128);
        $this->table = TableManager::getInstance()->get('ipList');
    }

    function access(string $ip):int
    {
        $key  = substr(md5($ip), 8,16);
        $info = $this->table->get($key);

        if ($info) {
            $this->table->set($key, [
                'lastAccessTime' => time(),
                'count'          => $info['count'] + 1,
            ]);
            return $info['count'] + 1;
        }else{
            $this->table->set($key, [
                'ip'             => $ip,
                'lastAccessTime' => time(),
                'count'          => $info['count'] + 1,
            ]);
            return 1;
        }
    }

    function clear()
    {
        foreach ($this->table as $key => $item){
            $this->table->del($key);
        }
    }

    function accessList($count = 10):array
    {
        $ret = [];
        foreach ($this->table as $key => $item){
            if ($item['count'] >= $count){
                $ret[] = $item;
            }
        }
        return $ret;
    }

}