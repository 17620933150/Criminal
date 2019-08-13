<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Business extends Common {
    public function Business(){
            $anli= db('cr_article')
                ->where('article_sort','25')
                ->alias('a')
                ->join('sh_sort b','a.article_sort = b.id ','LEFT')
                ->field('a.id,a.article_name,a.article_content,b.sort_name as fat_name')
                ->order('a.status DESC,a.zhidtime DESC,a.addtime DESC')
                ->select();//国晖案例列表
        return view('business/business',['anli'=>$anli]);
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
