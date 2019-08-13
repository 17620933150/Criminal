<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;
use app\admin\controller\Common;
//use think\controller;

//权限分类
class Roles extends Common {

    function roleslst() {
        $search = input('search');//关键字
        if ($search !== null) {
            $roles = db('sh_roles')
                ->where("rolefl","like","%".$search."%")
                ->paginate(12);
        }else {
            $roles = db('sh_roles')
                ->paginate(12);
        }

        return view('roles/roleslst',['roles'=>$roles,'search'=>$search]);

    }

    function rolesadd() {
        if(request()->isPost()) {
            $rolefl = input('post.');
            $ren = db('sh_roles')->where('rolefl',$rolefl['rolefl'])->find();
            if ( $ren !== NULL){
                $data['msg'] = '此权限分类已存在!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            $ren = db('sh_roles')->strict(false)->insert($rolefl);
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
        return view('roles/rolesadd');

    }

    function rolesedit() {
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
         if(request()->isPost()) {
             $rolefl = input('post.');

             $ren = db('sh_roles')
                 ->where('id',$key)
                 ->update([
                     'rolefl'=>$rolefl['rolefl'],
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

        $roleh = db('sh_roles')->where('id',$key)->find();
        return view('roles/rolesedit',['roleh'=>$roleh]);
    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('sh_roles')->delete($key);
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
