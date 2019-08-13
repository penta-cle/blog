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

class Articles extends Controller
{
    //判断登陆
    protected function _initialize()
    {
        if ((Session::has('loged_name', 'admin')) == NULL)
            return $this->error('请先登录', 'Login/index');
        else;
    }
    //添加按钮跳转
    public function add()
    {
        return $this->fetch("add");
    }
    //编辑跳转
    public function edit()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "" || $id == NULL)
            return $this->error("系统发生错误！");
        $res = Article::getId($id);
        // var_dump($res);
        $art = $res->getData();
        $this->assign("Article", $art);
        return $this->fetch("edit");
    }
    //detail中转跳转
    public function detail()
    {
        if (!input("?id"))
            return result(0, "系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Article::getId($id);
        $this->assign("Article", $res);
        return $this->fetch("detail");
    }

    //查询文章介绍信息
    public function select()
    {
        $list = Article::order('id desc')->paginate(10, false, ['query' => request()->param()]);
        $this->assign([
            "list" => $list,
            "apic" => Article::all(),
            "aname" => Article::all(),
            "atitle" => Article::all(),
            "fenlei" => Fenlei::all(),
            "id" => Article::all(),
        ]);
        // $this->assign("list", $list);
        return $this->fetch("list");
    }
//    //按发布人分类查询下拉
    public function getByName()
    {
        $name = input("name");
        if ($name == "all") {
            $all = Article::order('id desc')->paginate(10, false, ['query' => request()->param()]);
            $fenleis = Fenlei::all();
            $this->assign([
                "list" => $all,
                "apic" => Article::all(),
                "aname" => Article::all(),
                "atitle" => Article::all(),
                "fenlei" => Fenlei::all(),
                "id" => Article::all(),
            ]);
        } else {
            $arr = Article::where('aname', $name)->paginate(10, false, ['query' => request()->param()]);
            $fenleis = Fenlei::all();
            $this->assign([
                "list" => $arr,
                "apic" => Article::all(),
                "aname" => Article::all(),
                "atitle" => Article::all(),
                "fenlei" => Fenlei::all(),
                "id" => Article::all(),
            ]);
        }
        return $this->fetch("list");
    }

//    //文章搜索功能
//    public function Search()
//    {
//        $key = input('key');
//        $list = Article::SearchArticle($key);
//        $fenleis = Fenlei::all();
//        $this->assign([
//            "list" => $list,
//            "apic" => Article::all(),
//            "aname" => Article::all(),
//            "atitle" => Article::all(),
//            "fname" => $fenleis,
//            "id" => Article::all(),
//        ]);
//        return $this->fetch("list");
//    }


    //查看文章详情
    public function view()
    {
        $list = Article::order('id desc')->paginate(10);
        self::assign("list", $list);
        return self::fetch("view");
    }
    //添加文章
    public function add_article()
    {

        if (
            !input("?atitle") ||
            !input("?apic") ||
            !input("?aname") ||
            !input("?atext")  ||
            !input("?fenlei")
        )
            return $this->error("系统发生错误");
        $atitle = input("atitle");
        $apic = input("apic");
        $aname = input("aname");
        $atext = input("atext");
        $fenlei = input("fenlei");
        if (
            $atitle == "" || $apic == "" || $aname == "" || $atext == "" || $fenlei == "" ||
            $atitle == NULL || $apic == NULL || $aname == NULL || $atext == NULL || $fenlei == NULL
        )
            return $this->error("请输入完整内容");
        $Article = new Article();
        $Article->atitle = $atitle;
        $Article->apic = $apic;
        $Article->aname = $aname;
        $Article->atext = $atext;
        $Article->fenlei = $fenlei;
        $Article->save();
        if ($Article)
            return $this->success("添加成功");
        else if ($Article == NULL)
            return $this->error("添加失败");
    }
    //编辑文章
    public function update_article()
    {
        if (
            !input("?atitle") ||
            !input("?apic") ||
            !input("?aname") ||
            !input("?atext")
        )
            return $this->error("系统发生错误");
        $id = input("id");
        $atitle = input("atitle");
        $apic = input("apic");
        $aname = input("aname");
        $atext = input("atext");
        if (
            $id == "" || $atitle == "" || $apic == "" || $aname == "" || $atext == "" ||
            $id == NULL || $atitle == NULL || $apic == NULL || $aname == NULL || $atext == NULL
        )
            return $this->error("请输入完整内容");
        $Article = Article::find($id);
        $Article->atitle = $atitle;
        $Article->apic = $apic;
        $Article->aname = $aname;
        $Article->atext = $atext;
        $Article->save();

        if ($Article)
            return $this->success("修改成功", "Articles/detail?id=" . $Article->id);
        else if ($Article == NULL)
            return $this->error("修改失败");
    }
    //删除文章
    public function del_article()
    {
        if (!input("?id"))
            return $this->error("系统发生错误！");
        $id = input("id");
        if ($id == "")
            return $this->error("系统发生错误！");
        $res = Article::destroy($id);
        if ($res)
            return $this->success("删除成功");
        else if ($res == NULL)
            return $this->error("删除失败！");
    }
}
