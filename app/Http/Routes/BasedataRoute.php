<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'basedata'], function($router){
	$router->get('all','BaseDataController@all')->name('admin.basedata.all');
	$router->get('active','BaseDataController@active')->name('admin.basedata.active');
	$router->get('roles','BaseDataController@roles')->name('admin.basedata.roles');
	$router->get('online','BaseDataController@online')->name('admin.basedata.online');//name 为slug
//这里用那么  因为 这里的路由名称为ajaxindex   不是路径
	$router->get('ajaxBasedataAll','BaseDataController@ajaxBasedataAll')->name('admin.basedata.ajaxBasedataAll');
	$router->get('ajaxBasedataRoles','BaseDataController@ajaxBasedataRoles')->name('admin.basedata.ajaxBasedataRoles');
});


