<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use app\admin\controller;
use app\admin\controller\Common;

//use think\controller;


class Index extends Common {

    public function commonall() {

        $sidebar = db('sh_role')->where('role_id',Session('role_id'))->find();
        $ruleid = explode(",", $sidebar['auth_ids_list']);
        $rule = db('sh_rule')->where('id','in',$ruleid)->where('rule_sidebar','1')->select();
        $rule_roles = [];
        foreach ($rule as $k=>$v) {
            $rule_roles[] = $v['rule_roles'];
        }
        $roles = db('sh_roles')->where('id','in',$rule_roles)->select();
        return view('common/commonall',['rule'=>$rule,'roles'=>$roles]);

    }

    public function localimg() {
        $path = './upload';
        $results = $this->scanFile($path);
        return json($results);
    }


    protected function scanFile($path) {
        global $result;
        $exts = ['.jpg','.png','.gif','.jpeg'];
        $files = scandir($path);
        $tn = explode('.', $path);
        $tn = $tn[1];
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                if (is_dir($path . '/' . $file)) {
                    $this->scanFile($path . '/' . $file);
                } else {
                    $ext = strrchr($file,'.');
                    if (in_array($ext,$exts)) {
                        $result[] = $tn.'/'.$file;
                    }
                }
            }
        }
        return $result;
    }


    public function index() {
        $de  = [
            's'=>php_uname('s'),//获取系统类型
            'sysos'=>$_SERVER["SERVER_SOFTWARE"],//获取php版本及运行环境
            'phpinfo'=>PHP_VERSION,//获取PHP信息
            'arcount'=>db('cr_article')->count(),
            'liuyanw'=>db('cr_reserve')->where('status',0)->count(),
        ];
        return view('index/index',['de'=>$de]);

    }

}






?>
