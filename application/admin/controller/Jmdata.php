<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Jmdata extends Common {

    function jmlst() {
        $lunbotus = db('sh_jm')->order('zhidtime DESC')->paginate(10);
        return view('lunbotu/lunbotulst',['lunbotus'=>$lunbotus]);

    }

    function Lunbotuadd() {
         if(request()->isPost()) {
             $date = input('post.');
             $ren = db('sh_lunbotu')->strict(false)->insert($date);
             if ($ren == 1) {
                 $data['msg'] = '添加成功!';
                 $data['taatus'] = '200';
                 $data['way'] = 'true';
                 return json($data);
             }else{
                 $data['msg'] = '添加失败!';
                 $data['taatus'] = '500';
                 $data['way'] = 'false';
                 return json($data);
             }
         }
        return view('lunbotu/lunbotuadd');
    }





}






?>
