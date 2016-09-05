<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="antp">
	<head>
	    <meta charset="utf-8" />
	    <title></title>
	    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	    <meta content="" name="author" />
	    <link href="/public/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
	    <link href="/public/css/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all">
	    <link href="/public/css/custom.css" rel="stylesheet" type="text/css" media="all">
	    <script type="text/javascript" src="/public/js/angular.min.js"></script>
	    <script type="text/javascript" src="/public/js/angular-resource.min.js"></script>
	    <script type="text/javascript" src="/public/js/angular-ui-router.min.js"></script>
	    <script type="text/javascript" src="/public/js/jquery-1.10.1.min.js"></script>
	    <script type="text/javascript" src="/public/js/jquery-ui.min.js"></script>
	    <script type="text/javascript" src="/public/js/tm.pagination.js"></script>
	    <script type="text/javascript" src="/public/js/ng-file-upload.min.js"></script>
	    <script type="text/javascript" src="/public/js/ng-file-upload-shim.min.js"></script>
	    <script type="text/javascript" src="/public/js/layer/layer.js"></script>
	    <script type="text/javascript" src="/config.js"></script>
	    <script type="text/javascript" src="/app.js"></script>
		<link rel="shortcut icon" href="favicon.ico" />
	</head>
	<body>
		<div class="container-fluid">
	        <div class="row clearfix">
	            <div class="col-md-12" style="float: none;display: block;margin-left: auto;margin-right: auto;">
	                <div ui-view="main"></div>
	            </div>
	        </div>
	    </div>
	</body>
</html>