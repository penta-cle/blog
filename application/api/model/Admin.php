<?php

/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:57
 */
namespace app\api\model;
use think\Model;
use traits\model\SoftDelete;

class Admin extends Model
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'delete_time';
    public static function verify($username,$password){
        $user = Admin::where('username',$username)->find();
        if($user===NULL){
            return 404;
        }else{
            if($user->password === md5($password)){
                return 200;
            }else{
                return 500;
            }
        }
    }
}