<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class Business extends Common {
    public function Business(){
        $anli= db('sh_business')
                ->order('status DESC,zhidtime DESC,addtime DESC')
                ->select();//业务领域列表
        $title = db('sh_sort')
            ->where('id',25)
            ->field('seogjz,seoms')
            ->find();
        $title['article_name'] = '业务领域';
        return view('business/business',['anli'=>$anli,'title'=>$title]);
    }

    public function Businessdata(){
        $key = input('key');
        if ($key == null) {
            die('访问错误');
        }
        $anli = db('cr_article')->where('id',$key)->find();
        $title = db('cr_article')
            ->where('id',$key)
            ->field('article_name,seogjz,seoms')
            ->find();
        return view('business/businessdata',['anli'=>$anli,'title'=>$title]);
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
