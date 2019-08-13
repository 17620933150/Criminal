<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Faluzisi extends Common {
    public function Faluzisi(){
        $key = input('key');
        $sort = db('sh_sort')
            ->where('fat_id',$key)
            ->field('id,sort_name,seogjz,seoms')
            ->select();
            if (!empty($sort)) {
                foreach($sort as $v){
                    $sort_id[] = $v['id'];
                }
                $anli= db('cr_article')
                    ->where('article_sort','in',$sort_id)
                    ->alias('a')
                    ->join('sh_sort b','a.article_sort = b.id ','LEFT')
                    ->field('a.id,a.article_name,a.addtime,a.article_content,b.sort_name as fat_name')
                    ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
                    ->paginate(11);
            }else{
            $anli= db('cr_article')
                ->where('article_sort',$key)
                ->alias('a')
                ->join('sh_sort b','a.article_sort = b.id ','LEFT')
                ->field('a.id,a.article_sort,a.addtime,a.article_name,a.article_content,b.sort_name as fat_name')
                ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
                ->paginate(11);
            }
        $title = db('sh_sort')
            ->where('a.id',$key)
            ->alias('a')
            ->join('sh_sort b','a.fat_id = b.id ','LEFT')
            ->field('a.id,a.fat_id,a.sort_name,a.sort_name as article_name,a.seogjz,a.seoms,b.sort_name as fat_name')
            ->find();
            if (empty($sort)){
                $sort = db('sh_sort')
                    ->where('fat_id',$title['fat_id'])
                    ->field('id,sort_name,seogjz,seoms')
                    ->select();
            }
        $bt = db('sh_sort')
            ->where('id',$key)
            ->field('id')
            ->find();


        return view('article/article',['anli'=>$anli,'sort'=>$sort,'title'=>$title,'bt'=>$bt]);
    }
    public function Faluzisidata(){
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
        $anli = db('cr_article')
            ->where('a.id',$key)
            ->alias('a')
            ->join('sh_sort b','a.article_sort = b.id ','LEFT')
            ->field('a.id,a.article_sort,a.addtime,a.article_name,a.article_content,a.article_xbt,b.sort_name as fat_name')
            ->find();

        $title = db('sh_sort')
            ->where('a.id',$anli['article_sort'])
            ->alias('a')
            ->join('sh_sort b','a.fat_id = b.id ','LEFT')
            ->join('cr_article c',"c.id = $key",'LEFT')
            ->field('a.id,a.sort_name,b.sort_name as fat_name,c.article_name,c.seogjz,c.seoms')
            ->find();
        $bt = db('sh_sort')
            ->where('id',$key)
            ->field('id')
            ->find();
        return view('article/articledata',['articledata'=>$anli,'title'=>$title,'bt'=>$bt]);
    }
}
