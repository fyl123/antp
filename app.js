"use strict";
//开启一个AngularJS应用，应用名称为：antp
var app = angular.module("antp",["ui.router","ngResource","angularFileUpload","tm.pagination"]);
//使用ui.router的路由功能，通过config预先配置好访问url、该url对应的视图模板以及控制器等信息
app.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
	//启用HTML5模式的路由，该模式下会去除URL中的#号
	//$locationProvider.html5Mode(true);
	//默认页面，所有请求不到的资源，都会转向到这个URL
    $urlRouterProvider.otherwise("/index");
    $stateProvider.state("user", {
        url: "/user",
        views: {
            main: {
                templateUrl: "tpl/Admin/User/index.html",
                controller: "UserCtroller"
            }
        }
    }).state("index", {
        url: "/index",
        views: {
            main: {
                templateUrl: "tpl/Admin/Index/main.html",
                controller: "MainCtroller"
            }
        }
    }).state("user-add", {
        url: "/user/add",
        views: {
            main: {
                templateUrl: "tpl/Admin/User/add.html",
                controller: "UserFormCtroller"
            }
        }
    }).state("user-edit", {
        url: "/user/edit/:user_id",
        views: {
            main: {
                templateUrl: "tpl/Admin/User/add.html",
                controller: "UserFormCtroller"
            }
        }
    }).state("user-upload", {
        url: "/user/upload",
        views: {
            main: {
                templateUrl: "tpl/Admin/User/upload.html",
                controller: "UserUploadCtroller"
            }
        }
    });
});
//这里为了便于代码管理与维护，定义了若干个js模块，每个模块完成特定的功能
document.write('<script type="text/javascript" src="/tpl/Admin/Index/main.js"></script>');
document.write('<script type="text/javascript" src="/tpl/Admin/User/user.js"></script>');
