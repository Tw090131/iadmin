<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'basedata'], function($router){
	$router->get('all','BasedataController@all')->name('admin.basedata.all');
	$router->get('active','BasedataController@active')->name('admin.basedata.active');
	$router->get('roles','BasedataController@roles')->name('admin.basedata.roles');
	$router->get('online','BasedataController@online')->name('admin.basedata.online');
	$router->get('retention','BasedataController@retention')->name('admin.retention.retention');//name 为slug
	$router->get('lossrate','BasedataController@lossrate')->name('admin.retention.lossrate');
});


