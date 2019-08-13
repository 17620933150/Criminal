<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//
//Route::group('admin',function(){
//    Route::get('index','admin/AdminController/index',[],['id'=>'\d+']);
//    Route::get('login','admin/LoginController/index',[],['id'=>'\d+']);
//
//    Route::any('useradd','admin/UserController/user_add',[],['id'=>'\d+']);
//    Route::any(':name','blog/read',[],['name'=>'\w+']);
//});

Route::get('index','index/index/index');//律师团队
Route::get('zhun','index/index/index123456');//专题
Route::get('lawyer','index/lawyer/lawyer');//律师团队
Route::get('about','index/about/about');//关于我们
Route::get('cryer','index/crlawyer/crlawyerlst');//关于我们
Route::get('faluzisi/:key','index/faluzisi/faluzisi/');//国晖案例
Route::get('content/:key','index/faluzisi/Faluzisidata');//关于我们
Route::get('lawyers/:key','index/lawyer/lawyerdata');//关于我们
Route::get('business','index/business/business');//关于我们
Route::get('shanchu','index/index/shanchu');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];

