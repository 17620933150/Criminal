<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Lawyer extends Common {

    function lawyerlst() {
        $lawyers = db('sh_lawyer')
            ->paginate(12);
        return view('lawyer/lawyerlst',['lawyers'=>$lawyers]);
    }

    function lawyeradd() {
         if(request()->isPost()) {
             $date = input('post.');
             $date['addtime'] = date("Y-m-d H:i",time());
             $ren = db('sh_lawyer')->strict(false)->insert($date);
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
        return view('lawyer/lawyeradd');
    }

    function lawyeredit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_lawyer')
                ->where('id',$key)
                ->update([
                    'business_name'=>$date['business_name'],
                    'business_img'=>$date['business_img'],
                    'business_content'=>$date['business_content'],
                    'business_gzjy'=>$date['business_gzjy'],
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
        $lawyer = db('sh_lawyer')->where('id',$key)->find();
        return view('lawyer/lawyeredit',['lawyer'=>$lawyer]);
    }


    function lawyerstatus() {
        $date = input('post.');
        $date['zhidtime'] = date("Y-m-d H:i",time());
        $ren = db('sh_lawyer')->where('id',$date['key'])->update(['status'=>$date['status'],'zhidtime'=>$date['zhidtime']]);
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
            $del = db('sh_lawyer')->delete($key);
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
