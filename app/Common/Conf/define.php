<?php

//项目资源目录，不可更改
define('__PUBLIC__', './public/');
//项目模板目录
define('TMPL_PATH', ROOT_PATH.'tpl/');
//后台模板文件根目录
define('ADMIN_TMPL_PATH', APP_NAME.'tpl/');
//日志目录
define('FILE_LOG_PATH', ROOT_PATH . 'logs/');
//服务器访问URL
defined('SERVER_NAME') || define('SERVER_NAME', 'http://' . $_SERVER['HTTP_HOST'] . '/');
