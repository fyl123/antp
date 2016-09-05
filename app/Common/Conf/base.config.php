<?php
return array(
	'SHOW_ERROR_MSG'        =>  true,    			// 显示错误信息
	'SHOW_PAGE_TRACE'		=> 	false,				// 关闭页面Trace功能
	'TMPL_STRIP_SPACE'		=> 	true,				// 是否去除模板文件里面的html空格与换行
	'MODULE_ALLOW_LIST'  	=> 	array('Admin'),		// 允许访问的模块列表，多个模块用逗号分隔
 	'TMPL_DETECT_THEME'     => 	false,       		// 自动侦测模板主题
 	'TMPL_TEMPLATE_SUFFIX'  => 	'.html',     		// 默认模板文件后缀
	'DEFAULT_MODULE'        =>  'Admin',  			// 默认模块
	'DEFAULT_CONTROLLER'    =>  'Index', 			// 默认控制器名称
	'DEFAULT_ACTION'        =>  'index', 			// 默认操作名称
	'DEFAULT_M_LAYER'       =>  'Model', 			// 默认的模型层名称
	'DEFAULT_C_LAYER'       =>  'Controller', 		// 默认的控制器层名称		
	'DEFAULT_FILTER'        =>  'htmlspecialchars', // 默认参数过滤方法 用于I函数...htmlspecialchars		
	'LANG_SWITCH_ON'        => 	true,   			// 开启语言包功能		
	'VAR_MODULE'            =>  'g',     			// 默认模块获取变量
	'VAR_CONTROLLER'        =>  'm',    			// 默认控制器获取变量
	'VAR_ACTION'            =>  'a',    			// 默认操作获取变量		
	'APP_USE_NAMESPACE'     =>	true, 				// 关闭应用的命名空间定义
	'APP_AUTOLOAD_LAYER'    =>  'Action,Model', 	// 模块自动加载的类库后缀		
	'TMPL_ACTION_ERROR' 	=> 	'Public:error', 	// 默认错误跳转对应的模板文件,注：相对于前台模板路径
	'TMPL_ACTION_SUCCESS' 	=> 	'Public:success', 	// 默认成功跳转对应的模板文件,注：相对于前台模板路径
	'TMPL_EXCEPTION_FILE'   => 	__PUBLIC__.'exception.html',	//程序异常页面
		
	/* URL设置 */
 	'URL_CASE_INSENSITIVE'  =>	true,   			// 默认false 表示URL区分大小写 true则表示不区分大小写
 	'URL_MODEL'             => 	1,       			// URL访问模式,可选参数0、1、2、3,代表以下四种模式：
 													// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  
 													// 默认为PATHINFO 模式，提供最好的用户体验和SEO支持
 	'URL_PATHINFO_DEPR'     =>	'/',				// PATHINFO模式下，各参数之间的分割符号
 	'URL_HTML_SUFFIX'       =>	'',  				// URL伪静态后缀设置

	'VAR_PAGE'				=>	'p',				// 分页参数
		
	'URL_ROUTER_ON'			=> 	true,
		
	/*性能优化*/		
	'OUTPUT_ENCODE'			=>	true,				// 页面压缩输出
	'HTML_FILE_SUFFIX'  	=>  '.html', 			// 设置静态缓存文件后缀
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => APP_NAME.'public',
		'__CSS__' => APP_NAME.'public/css',
		'__JS__' => APP_NAME.'public/js',
	),
	'UPLOAD_DIR' => ROOT_PATH.'upload/',			// 上传目录
	'UPLOAD_FILE_RULE' => 'uniqid'					// 上传文件的命名规则
);
