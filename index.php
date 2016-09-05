<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
//网站当前路径
define('ROOT_PATH', './');
//项目名称，必须以斜杠/结尾
define('APP_NAME', '/');
//项目路径，不可更改
define('APP_PATH', ROOT_PATH . 'app/');
//定义运行时目录
define('RUNTIME_PATH', ROOT_PATH.'/runtime/');

// 引入ThinkPHP入口文件
require ROOT_PATH.'core/ThinkPHP.php';
