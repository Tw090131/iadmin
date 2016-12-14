<?php
//这些配置 在 后台检查权限有用
return [
	'menus' => [
		'add' => 'admin.menus.add',
		'edit' => 'admin.menus.edit',
		'delete' => 'admin.menus.delete',

	],
	'permissions' => [
		'list' => 'admin.permissions.list',
		'add' => 'admin.permissions.add',
		'edit' => 'admin.permissions.edit',
		'delete' => 'admin.permissions.delete',
	],
	'users' => [
		'create' 	=> 'admin.users.create',
		'edit' 		=> 'admin.users.edit',
		'delete' 	=> 'admin.users.delete',
		'trash' 	=> 'admin.users.trash',
		'undo' 		=> 'admin.users.undo',
		'list' 		=> 'admin.users.list',
		'audit'		=> 'admin.users.audit',
		'show'		=> 'admin.users.show',
		'reset'		=> 'admin.users.reset',
	],
	'game' => [
		'create' 	=> 'admin.game.create',
		'edit' 		=> 'admin.game.edit',
		'delete' 	=> 'admin.game.delete',
		'trash' 	=> 'admin.game.trash',
		'undo' 		=> 'admin.game.undo',
		'list' 		=> 'admin.game.list',
		'audit'		=> 'admin.game.audit',
		'show'		=> 'admin.game.show',
		'reset'		=> 'admin.game.reset',
	],
	'roles' => [
		'add' 	=> 'admin.roles.add',
		'edit' 		=> 'admin.roles.edit',
		'delete' 	=> 'admin.roles.delete',
		'trash' 	=> 'admin.roles.trash',
		'undo' 		=> 'admin.roles.undo',
		'list' 		=> 'admin.roles.list',
		'audit'		=> 'admin.roles.audit',
		'show'		=> 'admin.roles.show',
		'reset'		=> 'admin.roles.reset',
	],
	'home' => [
		'add' 	=> 'admin.home.add',
		'edit' 		=> 'admin.home.edit',
		'delete' 	=> 'admin.home.delete',
		'trash' 	=> 'admin.home.trash',
		'undo' 		=> 'admin.home.undo',
		'list' 		=> 'admin.system.login',
		'audit'		=> 'admin.home.audit',
		'show'		=> 'admin.home.show',
		'reset'		=> 'admin.home.reset',
	],
	'tools' => [
		'icon' 	=> 'admin.tools.icon',
		'edit' 		=> 'admin.home.edit',
		'delete' 	=> 'admin.home.delete',
		'trash' 	=> 'admin.home.trash',
		'undo' 		=> 'admin.home.undo',
		'list' 		=> 'admin.system.login',
		'audit'		=> 'admin.home.audit',
		'show'		=> 'admin.home.show',
		'reset'		=> 'admin.home.reset',
	],
	'basedata' => [
		'setappid'=>true,
		'all' 	=> 'admin.basedata.all',
		'active' 	=> 'admin.basedata.active',
		'roles' 	=> 'admin.basedata.roles',
		'online' 	=> 'admin.basedata.online',
	],
	'retention' => [
		'setappid'=>true,
		'retention' 	=> 'admin.retention.retention',
		'lossrate' 	=> 'admin.retention.lossrate',
	],

	'paydata' => [
		'setappid'=>true,
		'bill' 	=> 'admin.paydata.bill',
		'payrate' 	=> 'admin.paydata.payrate',
		'ltv' 	=> 'admin.paydata.ltv',
	],

	'recharge' => [
		'setappid'=>true,
		'record' 	=> 'admin.paydata.record',
		'rank' 	=> 'admin.paydata.rank',
		'vip' 	=> 'admin.paydata.vip',
		'first' 	=> 'admin.paydata.first',
	],

	'channel_area' => [
		'setappid'=>true,
		'channeldata' 	=> 'admin.channel_area.channeldata',
		'areadata' 	=> 'admin.channel_area.areadata',

	],

];