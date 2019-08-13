<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\controller\Common;
use think\Request;

class Sort extends Common{

    public function sortlst(){


        $sort = db('sh_sort')
            ->alias('a')
            ->join('sh_sort b','a.fat_id = b.id ','LEFT')
            ->field('a.*,b.sort_name as fat_name')
            ->order('id ASC')
            ->select();
        $sort = $this->Sort_Recursive($sort);

        return view('sort/sortlst',['sort'=>$sort]);
    }

    public function sortadd() {
        if (request()->isPost()) {
            $sort = input('post.');
            $en = db('sh_sort')->where('sort_name',$sort['sort_name'])->find();
            if ($en !== null){
                $data['msg'] = '该分类也存在!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
            }
            $sort['addtime'] = date("Y-m-d H:i:s");
            $ren = db('sh_sort')->strict(false)->insert($sort);
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
        $sort = db('sh_sort')->field('id,sort_name,fat_id')->order('id ASC')->select();
        $sort = $this->Sort_Recursive($sort);
        return view('sort/sortadd',['sort'=>$sort]);
    }

    public function sorteite() {
        if (request()->isPost()) {
            $key = input('key');
            $business = input('post.');
            $business['addtime'] = date("Y-m-d H:i:s");
            $ren = db('cr_sort')
                ->where('id',$key)
                ->update([
                    'sort_name'=>$business['sort_name'],
                    'seogjz'=>$business['seogjz'],
                    'seoms'=>$business['seoms'],
                    'fat_id'=>$business['fat_id'],
                    'addtime'=>$business['addtime']
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
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
        $business = db('sh_sort')->where('id',$key)->find();
        $sort = db('sh_sort')->field('id,sort_name,fat_id')->select();
        $sort = $this->Sort_Recursive($sort);
        return view('sort/sortelit',['business'=>$business,'sort'=>$sort]);
    }

    public function del() {
        if(request()->isPost()) {
            $key = input('key');
            $ren = db('sh_sort')->where('fat_id',$key)->find();
            $re = db('sh_article')->where('article_sort',$key)->find();
            if ($re !== null) {
                $data['msg'] = '无法删除,此分类下存在存在文章!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
                die;
            }
            if ($ren !== null) {
                $data['msg'] = '无法删除,此分类下存在子分类!';
                $data['taatus'] = '500';
                $data['way'] = 'false';
                return json($data);
                die;
            }
            $del = db('cr_sort')->delete($key);
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
