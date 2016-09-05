<?php
return array(
	'URL_ROUTE_RULES' => array(
		array('api/users/:id','Admin/User/user_get','',array('method'=>'get')),
		//注意：列表记录对应的路由必须要放在单条记录路由的后面，否则无法获取单条记录
		array('api/users','Admin/User/user_get','',array('method'=>'get')),
		array('api/users','Admin/User/user_post','',array('method'=>'post')),
		array('api/users/:id','Admin/User/user_put','',array('method'=>'put')),
		array('api/users/:id','Admin/User/user_delete','',array('method'=>'delete')),
	)
);