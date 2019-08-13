<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Friend extends Common {

    function friendlst() {
        $friends = db('sh_friend')
            ->paginate(12);
        return view('friend/friendlst',['friends'=>$friends]);

    }

    function friendadd() {
         if(request()->isPost()) {
             $date = input('post.');
             $date['addtime'] = date("Y-m-d H:i",time());
             $ren = db('sh_friend')->strict(false)->insert($date);
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
        return view('friend/friendadd');
    }

    function friendedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_friend')
                ->where('id',$key)
                ->update([
                    'friend_name'=>$date['friend_name'],
                    'friend_url'=>$date['friend_url'],
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
        $friend = db('sh_friend')->where('id',$key)->find();
        return view('friend/friendedit',['friend'=>$friend]);
    }


    function friendstatus() {
        $date = input('post.');
        $date['zhidtime'] = date("Y-m-d H:i",time());
        $ren = db('sh_friend')->where('id',$date['key'])->update(['status'=>$date['status'],'zhidtime'=>$date['zhidtime']]);
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
            $del = db('sh_friend')->delete($key);
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




    public function file() {
        $domain= Request::instance()->domain();
        $file = request()->file('upfile');
          if(empty($file)) {
            $this->error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH.'public'.DS.'upload');
        //如果不清楚文件上传的具体键名，可以直接打印$info来查看
        //获取文件（文件名），$info->getFilename()  ***********不同之处，笔记笔记哦
        //获取文件（日期/文件名），$info->getSaveName()  **********不同之处，笔记笔记哦
        if ($info->getSaveName()) {
            $data['msg'] = '上传成功!';
            $data['taatus'] = '200';
            $data['url'] = $domain.DS.'upload'.DS.$info->getSaveName();

            $data['way'] = 'true';
            return json($data);
        }else {
            $data['msg'] = '上传失败!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            return json($data);
        }
    }

}






?>
