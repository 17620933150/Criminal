<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;

//use think\controller;
use app\admin\controller\Common;

//角色模块
class Role extends Common {

    function rolelst() {
         $search = input('search');//关键字
        if ($search !== null ) {
            $role = db('sh_role')
                ->where("role_name","like","%".$search."%")
                ->select();
        }else {
            $role = db('sh_role')->select();
        }

        $rulet = [];
        foreach ($role as $k=>$v) {
            $pieces = explode(",", $v['auth_ids_list']);
            $rule = db('sh_rule')->where('id','in',$pieces)->field('rule_name')->select();
            foreach ($rule as $key=>$value) {
                $rulet[] = $value['rule_name'];
            }
            $role[$k]['auth_ids_list'] = implode(",", $rulet);
            $rulet = [];
        }
        return view('role/rolelst',['role'=>$role,'search'=>$search]);

    }

    function roleadd() {
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_role')->where('role_name',$date['role_name'])->find();
            if ( $ren !== NULL){
                $data['msg'] = '此角色已存在!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            $ren = db('sh_role')->strict(false)->insert($date);
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
        $rule = db("sh_rule")->select();//权限
        $roles = db("sh_roles")->select();//权限分类
        return view('role/roleadd',['roles'=>$roles,'rule'=>$rule]);
    }

    function roleedit() {
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
         if(request()->isPost()) {
             $rolefl = input('post.');
             $ren = db('sh_role')
                 ->where('role_id',$key)
                 ->update([
                     'role_name'=>$rolefl['role_name'],
                     'auth_ids_list'=>$rolefl['auth_ids_list'],
                     'role_rema'=>$rolefl['role_rema'],
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
        $rule = db("sh_rule")->select();//权限
        $roles = db("sh_roles")->select();//权限分类
        $role = db("sh_role")->where('role_id',$key)->find();
        $rofl = db('sh_rule')->where('id','in',explode(",", $role['auth_ids_list']))->field('rule_roles')->select();
        $rolefl = [];
        foreach ($rofl as $k=>$v) {
            $rolefl[] = $v['rule_roles'];
        }
        $rolefl = implode(",", $rolefl);
        return view('role/roleedit',['roles'=>$roles,'rule'=>$rule,'role'=>$role,'rolefl'=>$rolefl]);
    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('sh_role')->delete($key);
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
