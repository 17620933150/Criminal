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
            $ren = db('cr_home')
                ->where('id',1)
                ->update([
                    'guohuijs'=>$date['guohuijs'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'bg_img1'=>$date['bg_img1'],
                    'bg_img2'=>$date['bg_img2'],
                    'bg_img3'=>$date['bg_img3'],
                    'lianxiwomen'=>$date['lianxiwomen'],
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

        return view('jsao/jsaoedit',['jsao'=>$jsao]);
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


}






?>
