<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'index'], function($router){
	$router->get('gamelist','IndexController@gamelist');
});

