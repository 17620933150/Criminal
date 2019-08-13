<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class About extends Common {
    public function About(){
        $about = db('cr_home')->field('guohuijs,lianxiwomen,bg_img1,bg_img2,bg_img3,bg_content')->find('1');
        $title = db('cr_home')->field('gy_seogjz as seogjz,gy_seoms as seoms')->find('1');
        $title['article_name'] = '关于我们';
        return view('about/about',['about'=>$about,'title'=>$title]);
    }
}
