<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;

use app\admin\controller\Common;
use think\helper\hash\Md5;


class User extends Common {

    function userlst() {
        if (session('role_id') !== '1') {
            $whereArr['a.role_id'] =  array('neq',1);
            $users = db('sh_user')
                ->where($whereArr)
                ->alias('a')
                ->join('sh_role b','a.role_id = b.role_id','LEFT')
                ->field('a.*,b.role_name')
                ->paginate(12);
        }else {
            $users = db('sh_user')
                ->alias('a')
                ->join('sh_role b','a.role_id = b.role_id','LEFT')
                ->field('a.*,b.role_name')
                ->paginate(12);
        }
        return view('user/userlst',['users'=>$users]);
    }

    function useradd() {
         if(request()->isPost()) {
             $date = input('post.');
             $ren = db('sh_user')->where('username',$date['username'])->find();
             $phone = db('sh_user')->where('phone',$date['phone'])->find();
             if ( $ren !== NULL){
                 $data['msg'] = '员工已存在!';
                 $data['taatus'] = '500';
                 $data['way'] = 'false';
                 return json($data);
             }
             if ( $phone !== NULL){
                 $data['msg'] = '电话号码已存在!';
                 $data['taatus'] = '500';
                 $data['way'] = 'false';
                 return json($data);
             }
             $date['create_time'] = time();
             $date['password'] = '123456';
             $date['password'] = \md5($date['password'].config('mimayan'));
             $ren = db('sh_user')->strict(false)->insert($date);
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
         if (session('role_id') !== '1') {
             $whereArr['role_id'] =  array('neq',1);
             $role = db('sh_role')->where($whereArr)->select();
         }else {
             $role = db('sh_role')->select();
         }

        return view('user/useradd',['role'=>$role]);
    }

    function useredit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_user')
                ->where('user_id',$key)
                ->update([
                    'username'=>$date['username'],
                    'role_id'=>$date['role_id'],
                    'phone'=>$date['phone'],
                    'email'=>$date['email'],
                    'status'=>$date['status'],
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

        $user = db('sh_user')->where('user_id',$key)->find();
        $role = db('sh_role')->select();
        return view('user/useredit',['role'=>$role,'user'=>$user]);
    }


    function psd() {
        $date = input('post.');
        $date['password'] = \md5('123456'.config('mimayan'));
        $psd = db('sh_user')->where('user_id',$date['key'])->field('password')->find();
        if ($date['password'] == $psd['password']) {
            $data['msg'] = '已重置!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            return json($data);
        }
        $ren = db('sh_user')->where('user_id',$date['key'])->update(['password'=>$date['password']]);
        if ($ren == 1 ) {
            $data['msg'] = '重置成功!';
            $data['taatus'] = '200';
            $data['way'] = 'true';
            return json($data);
        }else{
            $data['msg'] = '重置失败!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            return json($data);
        }
    }


    function xgpsd() {
        $key = input('key');
       if(request()->isPost()) {
           $date = input('post.');
           $date['psd'] = \md5($date['psd'].config('mimayan'));
           $date['newpsd'] = \md5($date['newpsd'].config('mimayan'));
           if ($date['psd'] == $date['newpsd']) {
               $data['msg'] = '与原密码一致!';
               $data['taatus'] = '500';
               $data['way'] = 'false';
               return json($data);
           }
           $pwd = db('sh_user')->where('user_id',$key)->field('password')->find();
           if($date['psd'] !== $pwd['password']) {
               $data['msg'] = '原密码错误!';
               $data['taatus'] = '500';
               $data['way'] = 'false';
               return json($data);
           }
           $ren = db('sh_user')->where('user_id',$key)->update(['password'=>$date['newpsd']]);
           if ($ren == 1 ) {
               $data['msg'] = '重置成功!';
               $data['taatus'] = '200';
               $data['way'] = 'true';
               session(null);
               return json($data);
           }else{
               $data['msg'] = '重置失败!';
               $data['taatus'] = '500';
               $data['way'] = 'false';
               return json($data);
           }
       }
        return view('user/psdedit');


    }


    function userstatus() {
        $date = input('post.');
        $ren = db('sh_user')->where('user_id',$date['key'])->update(['status'=>$date['status']]);

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
            $del = db('sh_user')->delete($key);
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
