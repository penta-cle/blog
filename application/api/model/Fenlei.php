<?php

/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:48
 */

namespace app\api\model;

use think\Model;
use traits\model\SoftDelete;

class Fenlei extends Model
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';

}
