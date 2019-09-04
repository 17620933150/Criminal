<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Jsao extends Common {
    function jsaoedit() {
        if(request()->isPost()) {
            $date = input('post.');
            $date['addtime'] = date("Y-m-d H:i",time());
            $ren = db('sh_jsao')
                ->where('id',1)
                ->update([
                    'title'=>$date['title'],
                    'phone'=>$date['phone'],
                    'js_content'=>$date['js_content'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'js_img'=>$date['js_img'],
                    'fax'=>$date['fax'],
                    'zipcode'=>$date['zipcode'],
                    'address'=>$date['address'],
                    'addtime'=>$date['addtime'],
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
        $jsao = db('sh_jsao')->where('id',1)->find();
        return view('jsao/jsaoedit',['jsao'=>$jsao]);
    }

    function officeimgs() {
        if(request()->isPost()) {
            $date = input('post.');
            $date['addtime'] = date("Y-m-d H:i",time());
            $ren = db('sh_officeimg')
                ->where('id',1)
                ->update([
                    'title'=>$date['title'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'bg_imgs'=>$date['bg_imgs'],
                    'addtime'=>$date['addtime'],
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
        $jsao = db('sh_officeimg')->where('id',1)->find();
        return view('jsao/officeimgedit',['jsao'=>$jsao]);
    }

    function xiagnmuedit() {
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('cr_home')
                ->where('id',1)
                ->update([
                    'home_title'=>$date['home_title'],
                    'seoms'=>$date['seoms'],
                    'seogjz'=>$date['seogjz'],
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
        $jsao = db('cr_home')->where('id',1)->find();
        return view('jsao/xiangmuedit',['xm'=>$jsao]);
    }

    function contactosedit() {
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_contactos')
                ->where('id',1)
                ->update([
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'contactos'=>$date['contactos'],
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
        $jsao = db('sh_contactos')->where('id',1)->find();
        return view('jsao/contactos',['jsao'=>$jsao]);
    }


}






?>
