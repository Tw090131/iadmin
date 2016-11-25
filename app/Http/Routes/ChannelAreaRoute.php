<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'c-a'], function($router){
	$router->get('channeldata','ChannelAreaController@channeldata')->name('admin.channel_area.channeldata');
	$router->get('areadata','ChannelAreaController@areadata')->name('admin.channel_area.areadata');

});


