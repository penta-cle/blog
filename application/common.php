<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function result($code, $data = '')
{
    $msgs = [
        0 => "success",
        1 => "error",
        201 => "参数不足!",
        401 => "数据重复!",
        301 => "删除失败",
        500 => "操作失败!",
        202 => "组装数据出错",
    ];
    $arr = [
        'code' => $code,
        'msg' => $msgs[$code],
        'data' => $data,
    ];
    return json($arr);
}

//快捷访问json接口
function jsonapi($url)
{
    $res = json_decode(file_get_contents($url), true);
//    dump($res);
    return $res;
}

