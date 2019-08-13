<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Lunbotu extends Common {

    function Lunbotulst() {
        $lunbotus = db('sh_lunbotu')->order('flag DESC,zhidtime DESC')->paginate(10);
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

    function lunbotuedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_lunbotu')
                ->where('id',$key)
                ->update([
                    'img_url'=>$date['img_url'],
                    'img_dz'=>$date['img_dz'],
                ]);
            if ($ren == 1) {
                $data['msg'] = '修改成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '修改失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }

        $Lunbotu = db('sh_lunbotu')->where('id',$key)->find();
        return view('lunbotu/lunbotuedit',['lunbotu'=>$Lunbotu]);
    }


    function Lunbotustatus() {
        $date = input('post.');
        $date['zhidtime'] = date("Y-m-d H:i",time());
        $ren = db('sh_lunbotu')->where('id',$date['key'])->update(['flag'=>$date['status'],'zhidtime'=>$date['zhidtime']]);
        if ($ren == 1 ) {
            $data['msg'] = '更新成功!';
            $data['taatus'] = '200';
            $data['way'] = 'true';
            $data['status'] =$date['status'];
            return json($data);
        }else{
            $data['msg'] = '更新失败!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            $data['status'] ='0';
            return json($data);
        }

    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('sh_lunbotu')->delete($key);
            if ($del == 1 ) {
                $data['msg'] = '删除成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '删除失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
        }else{
            die('访问错误');
        }
    }

}






?>
