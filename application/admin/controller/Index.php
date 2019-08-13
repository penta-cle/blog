<?php

/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:57
 */

namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Cache;

class Index extends Controller
{

    //判断登陆
    protected function _initialize()
    {
        if ((Session::has('loged_name', 'admin')) == NULL)
            return $this->error('请先登录', 'Login/index');
        else;
    }

    public function index()
    {
        //获取系统概要信息
        $this->redirect("Login/index");
    }
//
//
//    //清除缓存
//    public function clear()
//    {
//        Cache::clear();
//        return $this->index();
//    }

//上传文件
    public function uploads()
    {
        // 获取表单上传文件
        $imgs = request()->file('imgs');
        $i = 0;$error=[];$path=[];
        $head = input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME');
        foreach($imgs as $file){

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH .'public'. DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                $path[$i] = $head."/uploads/".$info->getSavename();

            }else{
                // 上传失败获取错误信息
                $error[$i] = $file->getError();
            }
            $i++;
        }
        $data = [
            "path"=> $path,
            "error"=> $error,
        ];
        return json($data);
    }

    //上传文件
    public function upload()
    {
        // 获取表单上传文件
        $imgs = request()->file('imgs');
        $i = 0;$error=0;$path=[];
        $head = input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME');
        foreach($imgs as $file){

            $linshi = $file->move(ROOT_PATH .'public'. DS . 'linshi');
            if($linshi){

                $linshiname =  ROOT_PATH .'public'. DS . 'linshi'.DS;
                $linshiname .=  $linshi->getSavename();
                $image = \think\Image::open($linshiname);
                $image->thumb(750, 750)->save(ROOT_PATH .'public'. DS . 'uploads'.DS.$linshi->getSavename());
                // 移动到框架应用根目录/public/uploads/ 目录下
                //$info = $file->move(ROOT_PATH .'public'. DS . 'uploads');

                // 成功上传后 获取上传信息
                $path[$i] = $head."/uploads/".$linshi->getSavename();

//                $move_url = config(‘excel_path’);
//                $file = request()->file(‘xls_file’);
//                $info = $file->validate([‘size’=>52428800,’ext’=>’xls,xlsx’])->rule(‘uniqid’)->move($move_url);
//                unset($info);
//                unlink($linshiname);

            }else{
                // 上传失败获取错误信息
                $error[$i] = $file->getError();
            }
            $i++;
        }
        $data = [
            "data"=> $path,
            "errno"=> $error,
        ];
        return json($data);
    }

}