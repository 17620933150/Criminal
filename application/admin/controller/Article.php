<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\controller;
use app\admin\controller\Common;
use think\Request;
use think\helper\hash\Md5;


class Article extends Common {

    function articlelst() {
        $cateid = input('cateid');//分类
        $search = input('search');//关键字
        if ($cateid !== null || $search !== null ) {
            if ($cateid !== '0') {
                $articles = db('cr_article')
                    ->alias('a')
                    ->join('sh_sort b','a.article_sort = b.id','LEFT')
                    ->where("a.article_name","like","%".$search."%")
                    ->where('a.article_sort',$cateid)
                    ->order('status DESC,zhidtime DESC,addtime DESC')
                    ->field('a.*,b.sort_name')
                    ->paginate(12, false, ['query' =>['cateid'=>$cateid,'search'=>$search],]);
            }else {
                $articles = db('cr_article')
                    ->alias('a')
                    ->join('sh_sort b','a.article_sort = b.id','LEFT')
                    ->where("a.article_name","like","%".$search."%")
                    ->order('status DESC,zhidtime DESC,addtime DESC')
                    ->field('a.*,b.sort_name')
                    ->paginate(12, false, ['query' =>['cateid'=>$cateid,'search'=>$search],]);
            }
        }else {
            $articles = db('cr_article')
                ->alias('a')
                ->join('sh_sort b','a.article_sort = b.id','LEFT')
                ->order('status DESC,zhidtime DESC,addtime DESC')
                ->field('a.*,b.sort_name')
                ->paginate(12);
        }
        $sort = db('sh_sort')->select();
        $sort = $this->Sort_Recursive($sort);
        return view('article/articlelst',['articles'=>$articles,'sort'=>$sort,'cateid'=>$cateid,'search'=>$search]);

    }

    function articleadd() {
         if(request()->isPost()) {
             $date = input('post.');
             $date['addtime'] = date("Y-m-d H:i",time());
             $ren = db('sh_article')->strict(false)->insert($date);
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
        $sort = db('sh_sort')->field('id,sort_name,fat_id')->select();
        $sort = $this->Sort_Recursive($sort);
        return view('article/articleadd',['sort'=>$sort]);
    }

    function articleedit() {
        $key = input('key');
        if(request()->isPost()) {
            $date = input('post.');
            $ren = db('cr_article')
                ->where('id',$key)
                ->update([
                    'article_name'=>$date['article_name'],
                    'article_xbt'=>$date['article_xbt'],
                    'article_fm'=>$date['artcle_fm'],
                    'seogjz'=>$date['seogjz'],
                    'seoms'=>$date['seoms'],
                    'article_sort'=>$date['article_sort'],
                    'article_content'=>$date['article_content'],
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
        $article = db('cr_article')->where('id',$key)->find();
        $sort = db('sh_sort')->field('id,sort_name,fat_id')->select();
        $sort = $this->Sort_Recursive($sort);
        return view('article/articleedit',['sort'=>$sort,'article'=>$article]);
    }


    function articlestatus() {
        $date = input('post.');
        $date['zhidtime'] = date("Y-m-d H:i",time());
        $ren = db('sh_article')->where('id',$date['key'])->update(['status'=>$date['status'],'zhidtime'=>$date['zhidtime']]);
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
            $del = db('sh_article')->delete($key);
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
