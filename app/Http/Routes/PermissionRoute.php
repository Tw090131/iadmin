<?php
$router->group(['prefix' => 'permissions'],function ($router)
{
	$router->get('ajaxIndex','PermissionsController@ajaxIndex')->name('admin.permissions.ajaxIndex'); //这里用那么  因为 这里的路由名称为ajaxindex   不是路径
});
$router->resource('permissions','PermissionsController');