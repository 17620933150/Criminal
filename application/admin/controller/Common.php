<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

//use app\admin\controller;
use think\Session;
use think\helper\hash\Md5;

use think\Controller;


class Common extends Controller {

    function _initialize() {
        if (!session('?username') && !session('?user_id') && !session('?role_id')) {
            $this->redirect(url('admin/login/login'));
        }else{
            $ruleurl = session('ruleurl');
            //拼接获取到当前访问的控制器名和方法名,,转为小写
            $currenturl = strtolower('/admin/'.request()->controller().'/'.request()->action());//当前url
            //判断访问的权限是否在session所记录的权限中存在
            //  超级管理员 不做权限控制,直接放行,或访问index控制器也放行
            if (strtolower(request()->controller())=='index'){
                return;
            }
//            dump($currenturl);
//            dump($ruleurl);
            //非超级管理员 ,判断访问的权限是否在session所记录的权限中存在
            if (!in_array($currenturl,$ruleurl)){
                exit('访问错误');
            }
        }
    }
    //新闻分类
    protected function Sort_Recursive($arr,$fat_id=0,$lev=0) {
        static $result = [];
        foreach($arr as $k=>$v) {
            if ($v['fat_id'] == $fat_id) {
                $v['lev'] =$lev;
                $result[] = $v;
                unset($arr[$k]);
                $this->Sort_Recursive($arr,$v['id'],$lev+1);
            }
        }
        //返回结果
        return $result;
    }
        //图片上传
    protected function file() {
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
