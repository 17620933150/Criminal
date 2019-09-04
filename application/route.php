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
Route::get('office','index/about/office');//国晖办公室
Route::get('culture','index/about/culture');//国晖办公室
Route::get('contactus','index/about/contactus');//联系我们
Route::get('cryer','index/crlawyer/crlawyerlst');//关于我们
Route::get('faluzisi/:key','index/faluzisi/faluzisi');//新闻中心
Route::get('content/:key','index/faluzisi/Faluzisidata');//新闻详情
Route::get('banan','index/faluzisi/Banan');//办案风采
Route::get('lawyers/:key','index/lawyer/lawyerdata');//律师详情
Route::get('business','index/business/business');//业务领域
Route::get('buda/:key','index/business/Businessdata');//业务领域详情
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

