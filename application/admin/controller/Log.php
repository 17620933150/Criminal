<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Log extends Common {
        function loglst() {
            if (session('role_id') !== '1') {
                $userid = db('sh_user')->where('role_id',1)->field('user_id')->select();
                foreach($userid as $v){
                    $userid1[] = $v['user_id'];
                }
                $whereArr['a.user_id'] =  array('not in',$userid1);
                $log = db('sh_log')
                    ->alias('a')
                    ->where($whereArr)
                    ->join('sh_user b','a.user_id = b.user_id','LEFT')
                    ->order('addtime DESC')
                    ->field('a.*,b.username')
                    ->paginate(12);
            }else {
                $log = db('sh_log')
                    ->alias('a')
                    ->join('sh_user b','a.user_id = b.user_id','LEFT')
                    ->order('addtime DESC')
                    ->field('a.*,b.username')
                    ->paginate(12);
            }

            return view('log/loglst',['log'=>$log]);
        }
}



?>
