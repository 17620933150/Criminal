<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Crlawyer extends Common {
    public function crlawyerlst(){
        return view('crlawyer');
    }

    public function lstla() {
        return view('lstla');
    }
    public function lastd() {
        return view('lastd');
    }
    public function zixzx() {
        return view('zixzx');
    }
    public function lawyerdata(){
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
        $lawyerdata = db('sh_lawyer')->where('id',$key)->find();
        return view('lawyerdata',['lawyerdata'=>$lawyerdata]);
    }
}
