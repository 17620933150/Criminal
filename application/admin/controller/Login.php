<?php

namespace app\Admin\controller;
header("Content-Type:text/html; charset=utf-8");

use think\Controller;
use think\Request;


class Login extends Controller
{

    public function phpinfo() {
        var_dump(phpinfo());
    }
    //登录
    public function login()
    {
        if (request()->isPost()) {
            $date = input('post.');
            $data = $this->validation($date);
            return $data;
        }
        return view('login/login');

    }
    //退出
    public function quitlogin()
    {
        session(null);
        $this->redirect(url('admin/login/login'));
    }

    public function userfind()
    {
        $userfind = db('sh_user')->where('user_id',Session('user_id'))
            ->alias('a')
            ->join('sh_role b','a.role_id = b.role_id','LEFT')
            ->field('a.username,a.phone,a.email,b.role_name')
            ->find();
        return view('login/userfind',['userfind'=>$userfind]);

    }

    //判断用户密码是否正确
    protected function validation($date)
    {
        $user = db('sh_user')->whereOr(['username' => $date['username'], 'phone' => $date['username']])->where('status', '1')->find();
        if ($user == null) {
            $data['msg'] = '用户名错误!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            return json($data);
        }
        $date['password'] = \md5($date['password'] . config('mimayan'));
        if ($user['password'] == $date['password']) {
            $log = ['user_id' => $user['user_id'],'login_ip'=>$this->Clientip(),'addtime'=>date("Y-m-d H:i",time())];
            $ren = db('sh_log')->insert($log);
            if ($ren == 1) {
                $sidebar = db('sh_role')->where('role_id', $user['role_id'])->find();
                $ruleid = explode(",", $sidebar['auth_ids_list']);
                $rule = db('sh_rule')->where('id', 'in', $ruleid)->select();
                $ruleurl = [];
                foreach ($rule as $k => $v) {
                    $ruleurl[] = $v['rule_url'];
                }
                session('ruleurl', $ruleurl);
                Session('username', $user['username']);
                Session('user_id', $user['user_id']);
                session('role_id', $user['role_id']);
                $data['msg'] = '登录成功!';
                $data['taatus'] = '200';
                $data['way'] = 'true';
                return json($data);
            }
        } else {
            $data['msg'] = '密码错误!';
            $data['taatus'] = '500';
            $data['way'] = 'false';
            return json($data);
        }
    }
    //获取客户端IP
    protected function Clientip() {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $cip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }else{
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }

    //登录
    public function text()
    {
        return view('index/text');

    }


}


?>
