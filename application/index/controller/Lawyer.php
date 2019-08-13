<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Lawyer extends Common {
    public function lawyer(){
        return view('lawyer');
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
