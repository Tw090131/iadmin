<?php
return [
	// 自定义登录字段
	'redirectAfterLogout'=>'admin',
	'username' => 'username',
	'cache' => [
		'menuList' => 'menuList',
	],
	'list' => [
		'start' => 0,
		'length' => 10
	],

	'permissions' => [
		// 控制是否显示查看按钮
		'show' => false,
		// trait 中的 action 参数
		'action' => 'permissions',
	],

	'users' => [
		// 控制是否显示查看按钮
		'show' => true,
		// trait 中的 action 参数
		'action' => 'users',
	],

	'roles' => [
		// 控制是否显示查看按钮
		'show' => true,
		// trait 中的 action 参数
		'action' => 'roles',
	],
	'game' => [
		// 控制是否显示查看按钮
		'show' => false,
		// trait 中的 action 参数
		'action' => 'game',
	],
];