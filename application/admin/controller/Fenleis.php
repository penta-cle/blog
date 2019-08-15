<?php

/**
 * Created by PhpStorm.
 * User: Pentacle
 * Date: 2019/7/12
 * Time: 14:57
 */

namespace app\admin\Controller;

use app\admin\model\Article;
use app\admin\model\Fenlei;
use think\Controller;
use think\Session;

class Fenleis extends Controller
{
    //判断登陆
    protected function _initialize()
    {
        if ((Session::has('loged_name', 'admin')) == NULL)
            return $this->error('请先登录', 'Login/index');
        else;
    }

    //查询文章分类信息
    public function select()
    {
        $list = Article::order('id desc')->paginate(10, false, ['query' => request()->param()]);
        $fenlei = Article::find();
        $this->assign([
            "list" => $list,
            "fenlei" => Article::all(),
            "fname"=>Fenlei::field("fname")->select()
        ]);
        // $this->assign("list", $list);
        return $this->fetch("list");
    }

    //下拉菜单搜索方法
    public function getByName()
    {
        $name = input("name");
        if ($name == "all") {
            $list = Article::order('id desc')->paginate(10, false, ['query' => request()->param()]);
            $fenlei = Article::find();
            $this->assign([
                "list" => $list,
                "fname" => Fenlei::field("fname")->select()
            ]);
        } else {
            $list = Article::where('fenlei', $name)->paginate(10, false, ['query' => request()->param()]);
            $fenlei = Fenlei::find();
            $this->assign([
                "list" => $list,
                "fname" => Fenlei::field("fname")->select()
            ]);
        }
        return $this->fetch("list");
    }

    //评论前三查询
    public function pinglun_three()
    {
        $arr = Article::order('allpinglun desc')
            ->field(' id,aname, atext, atitle,allpinglun ,create_time ,update_time')
            ->limit(3)
            ->select();


        $atitle = Article::field("atitle")->find();
        $this->assign([
            "list" => $arr,
            "atitle" => $atitle,
            "fname" => Fenlei::all()
        ]);
        return $this->fetch("pinglun");
    }

    //点赞前三查询
    public function dianzan_three()
    {
        $arr = Article::order('allpinglun desc')
            ->field(' id,aname, atext, atitle,likes ,create_time ,update_time')
            ->limit(3)
            ->select();
        $atitle = Article::field("atitle")->find();
        $this->assign([
            "list" => $arr,
            "atitle" => $atitle,
            "fname" => Fenlei::all()
        ]);
        return $this->fetch("dianzan");
    }

    //添加分类
    public function add_fenlei(){
        if (!input("?fname"))
            return $this->error("系统发生错误！");
        $fname = input("fname");
        if ($fname == "" || $fname == NULL)
            return $this->error("请输入完整内容！");
        $Fenlei = new Fenlei();
        $Fenlei->fname = $fname;
        $Fenlei->save();
        return $this->success("添加成功");
    }
}
