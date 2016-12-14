<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'retention'], function($router){
	$router->get('retention','RetentionController@retention')->name('admin.retention.retention');//name 为slug
	$router->get('lossrate','RetentionController@lossrate')->name('admin.retention.lossrate');
	$router->get('ajaxRetentionIndex','RetentionController@ajaxRetentionIndex')->name('admin.retention.ajaxRetentionIndex'); //这里用那么  因为 这里的路由名称为ajaxindex   不是路径
});


