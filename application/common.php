<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// 判断手机还是pc
if (\think\Request::instance()->isMobile()) {
    define('VIEW_PATH', __DIR__ . '/index/view/mobile/');
} else {
    define('VIEW_PATH', __DIR__ . '/index/view/default/');
}