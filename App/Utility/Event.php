<?php
/**
 * Created by PhpStorm.
 * User: Siam
 * Date: 2020/12/7 0007
 * Time: 21:13
 */

namespace App\Utility;


use EasySwoole\Component\MultiEvent;
use EasySwoole\Component\Singleton;

class Event extends MultiEvent
{
    use Singleton;
}