<?php if (!defined('THINK_PATH')) exit();?><div ng-include="'tpl/Admin/Public/header.html'"></div>
<button type="button" class="btn btn-primary" ng-click="addAction()">新增</button>
<table class="table table-bordered table-striped" style="margin-top:15px;">
	<thead>
		<tr>
			<th>用户名</th>
			<th>邮箱</th>
			<th>手机号</th>
			<th>微信</th>
			<th>QQ</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="user in data.user">
			<td>
				<a ui-sref="user-edit({user_id:user.user_id})" ng-bind="user.user_name"></a>
			</td>
			<td ng-bind="user.email"></td>
			<td ng-bind="user.tel"></td>
			<td ng-bind="user.weixin"></td>
			<td ng-bind="user.qq"></td>
			<td>
				<button type="button" class="btn btn-link">
					<a ui-sref="user-edit({user_id:user.user_id})">修改</a>
				</button>
				<button type="button" class="btn btn-link" ng-click="deleteAction(user.user_id)">删除</button>
			</td>
		</tr>
	</tbody>
</table>