<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Business extends Common {

    function businesslst() {
        $search = input('search');//关键字
        if ( $search !== null ) {
                $businesss = db('sh_business')
                    ->where("bu_name","like","%".$search."%")
                    ->order('status DESC,zhidtime DESC,addtime DESC')
                    ->field('a.*,b.sort_name')
                    ->paginate(12, false, ['query' =>['search'=>$search],]);
        }else {
            $businesss = db('sh_business')
                ->order('status DESC,zhidtime DESC,addtime DESC')
                ->paginate(12);
        }
        return view('business/businesslst',['businesss'=>$businesss,'search'=>$search]);
    }

    function businessadd() {
         if(request()->isPost()) {
             $date = input('post.');
             $date['addtime'] = date("Y-m-d H:i",time());
             $ren = db('sh_business')->strict(false)->insert($date);
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
        return view('business/businessadd');
    }

    function businessedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('sh_business')
                ->where('id',$key)
                ->update([
                    'bu_name'=>$date['bu_name'],
                    'bu_xbt'=>$date['bu_xbt'],
                    'bu_sylog'=>$date['bu_sylog'],
                    'bu_syimg'=>$date['bu_syimg'],
                    'bu_fm'=>$date['bu_fm'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'bu_content'=>$date['bu_content'],
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
        $business = db('sh_business')->where('id',$key)->find();
        return view('business/businessedit',['business'=>$business]);
    }


    function businessstatus() {
        $date = input('post.');
        $date['zhidtime'] = date("Y-m-d H:i",time());
        $ren = db('sh_business')->where('id',$date['key'])->update(['status'=>$date['status'],'zhidtime'=>$date['zhidtime']]);
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
            $del = db('sh_business')->delete($key);
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
            $data['url'] = DS.'upload'.DS.$info->getSaveName();

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
