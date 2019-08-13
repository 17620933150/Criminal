<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Anli extends Common {
    public function Anli(){
        $sort = db('cr_sort')
            ->where('fat_id','22')
            ->field('id,sort_name')
            ->select();
        if (!empty($sort)) {
            foreach($sort as $v){
                $sort_id[] = $v['id'];
            }
            $anli= db('cr_article')
                ->where('article_sort','in',$sort_id)
                ->alias('a')
                ->join('cr_sort b','a.article_sort = b.id ','LEFT')
                ->field('a.id,a.article_name,a.article_content,b.sort_name as fat_name')
                ->order('a.flag DESC,a.zhidtime DESC,a.addtime DESC')
                ->paginate(11);//国晖案例列表
        }else{
            $anli= db('cr_article')
                ->where('article_sort','22')
                ->alias('a')
                ->join('cr_sort b','a.article_sort = b.id ','LEFT')
                ->field('a.id,a.article_name,a.article_content,b.sort_name as fat_name')
                ->order('a.flag DESC,a.zhidtime DESC,a.addtime DESC')
                ->paginate(11);//国晖案例列表
        }
        $title['sort_name'] = '国晖案例';
        return view('article/article',['anli'=>$anli,'sort'=>$sort,'title'=>$title]);
    }
    public function Anlidata(){
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
        $anli = db('cr_article')->where('id',$key)->find();
        return view('article/articledata',['articledata'=>$anli]);
    }
}
