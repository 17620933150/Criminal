<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Jiamen extends Common {

    function jiamenlst() {
        $search = input('search');//关键字
        if ($search !== null ) {
                $jiamens = db('cr_reserve')
                    ->where("re_name|re_phone|re_content","like","%".$search."%")
                    ->order('addtime DESC')
                    ->paginate(12, false, ['query' =>['search'=>$search],]);
        }else {
            $jiamens = db('cr_reserve')
                ->order('addtime DESC')
                ->paginate(12);
        }
        return view('jiamen/jiamenlst',['jiamens'=>$jiamens,'search'=>$search]);
    }
    function jiamenedit() {
        $key = input('key');
        $jiamen = db('cr_reserve')->where('id',$key)->find();
        db('cr_reserve')->where('id',$key)->update(['status'=>1,]);
        return view('jiamen/jiamenedit',['jiamen'=>$jiamen]);
    }
    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('cr_reserve')->delete($key);
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
