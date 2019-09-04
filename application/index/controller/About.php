<?php
namespace app\index\controller;

use think\Controller;
use app\index\controller\Common;

class About extends Common {
    public function About(){
        $about = db('sh_jsao')->find('1');
        $title = db('sh_jsao')->field('seogjz,seoms,title')->find('1');
        $title['article_name'] = '律所介绍';
        return view('about/about',['about'=>$about,'title'=>$title]);
    }

    public function Office(){
        return view('about/office');
    }

    public function Culture(){
        return view('about/culture');
    }

    public function Contactus() {
        $about = db('sh_contactos')->find('1');
        $title = db('sh_contactos')->field('seogjz,seoms')->find('1');
        $title['article_name'] = '联系我们';
        return view('about/contactus',['about'=>$about,'title'=>$title]);
    }
}
