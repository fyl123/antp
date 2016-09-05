//通过factory创建一个service，该service通过$resource返回了一个资源对象
//$resource负责与支持restful的服务端进行数据交互
app.factory("UserService", function($resource) {
    return $resource(globalConfig.API.URL + "users/:id", {
       id: "@id"
    },
    {
        //query方法要求服务端返回的数据格式为数组，如果返回的是非数组格式，需要在transformResponse函数中作转换处理
    	query: {
            method: "GET",
            isArray: false,
            transformResponse: function(data) {
            	var result = JSON.parse(data);
                return result;
            }
        },
        update: {
            method: "PUT"
        }
    });
});

//用户列表Ctroller
app.controller('UserCtroller', function($scope, $state, UserService) {
    $scope.data = {};
    //分页配置
    $scope.paginationConf = {
        currentPage: 1,
        itemsPerPage: 5,
        perPageOptions: [],
        rememberPerPage: 'perPageItems'
    };
    
  //获取用户列表
	var getUserList = function(){
		var params = {
	        currentPage: $scope.paginationConf.currentPage,
	        pageSize: $scope.paginationConf.itemsPerPage
	    }
	    UserService.query(params).$promise.then(
		    function(data){
		    	//设置记录总条数
		    	$scope.paginationConf.totalItems = data.total;
		    	//将查询结果赋值给data.user，模板中可以对data.user变量进行遍历
		    	$scope.data.user = data.user;
		    },
		    function(error) {
		        console.log("An error occurred", error);
		    }
		);
	};
	//监听分页
	$scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', getUserList);
    
    $scope.addAction = function() {
        $state.go("user-add");
    };
    $scope.deleteAction = function(user_id){
    	layer.confirm("确定要删除该用户吗", {
		  	btn: ['确定','取消']
		}, function(index){
		  	layer.close(index);
		  	UserService.remove({id:user_id}).$promise.then(
	  			function(res){
	  				if(res.status){
	  					$state.go("user",null,{
	  						reload:true
	  					});
	  				}else{
	  					
	  				}
	  			},
	  			function(error) {
	  				console.log("An error occurred", error);
	  			}
		  	);
		});
    }
});

//新增和修改用户Ctroller
app.controller('UserFormCtroller', function($scope, $state, $stateParams, UserService) {
	if($stateParams.user_id){
		var user_id = $stateParams.user_id;
		var param = {id:user_id};
		//获取指定用户
		UserService.get(param).$promise.then(
	    	function(res) {
	            $scope.user = res;
	        },
	        function(error) {
	            console.log("An error occurred", error);
	        }
	    );
	}
    $scope.submitAction = function(userForm) {
        if(!userForm.$valid){
        	return false;
        }
        if($stateParams.user_id){
        	//更新用户信息
        	UserService.update(param,$scope.user).$promise.then(
    			function(res) {
    				if(res.status){
    					$state.go("user");
    				}else{
    					
    				}
    			},
    			function(error) {
    				console.log("An error occured", error);
    			}
        	);
        }else{
        	//新增
        	UserService.save($scope.user).$promise.then(
    			function(res) {
    				if(res.status){
    					$state.go("user");
    				}else{
    					
    				}
    			},
    			function(error) {
    				console.log("An error occured", error);
    			}
        	);
        }
    };
    $scope.cancelAction = function() {
    	$state.go("user");
    };
});

//用户上传Ctroller
app.controller('UserUploadCtroller', function($scope, Upload) {
	$scope.submit = function() {
		if ($scope.form.file.$valid && $scope.file) {
	    	$scope.upload($scope.file);
	    }
	};
});


