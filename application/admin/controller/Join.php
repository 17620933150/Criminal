<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;

use app\admin\controller\Common;

use think\controller;

//权限
class Join extends Common {

    function join() {
//        $rule = db('sh_rule')
//                ->alias('a')
//                ->join('sh_roles b','a.rule_roles = b.id','LEFT')
//                ->field('a.*,b.rolefl as roles_name')
//                ->select();
        return view('join/joinlst');
    }

    function joinadd() {
        if(request()->isPost()) {
            $rolefl = input('post.');
            $ren = db('sh_rule')->where('rule_url',$rolefl['rule_url'])->find();
            $ren1 = db('sh_rule')->where('rule_name',$rolefl['rule_name'])->find();
            if ( $ren !== NULL && $ren1 !== NULL){
                $data['msg'] = '此权限已存在!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            $ren = db('sh_rule')->strict(false)->insert($rolefl);
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
        $roles = db('sh_roles')->select();
        return view('join/joinadd',['roles'=>$roles]);
    }

    function ruleedit() {
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
         if(request()->isPost()) {
             $rolefl = input('post.');
             $ren = db('sh_rule')
                 ->where('id',$key)
                 ->update([
                     'rule_name'=>$rolefl['rule_name'],
                     'rule_url'=>$rolefl['rule_url'],
                     'rule_roles'=>$rolefl['rule_roles'],
                     'rule_sidebar'=>$rolefl['rule_sidebar'],
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
        $roles = db('sh_roles')->select();
        $ruleh = db('sh_rule')->where('id',$key)->find();
        return view('rule/ruleedit',['ruleh'=>$ruleh,'roles'=>$roles]);
    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $del = db('sh_rule')->delete($key);
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
