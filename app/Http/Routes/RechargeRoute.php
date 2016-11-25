<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'recharge'], function($router){
	$router->get('record','RechargeController@record')->name('admin.recharge.record');
	$router->get('rank','RechargeController@rank')->name('admin.recharge.rank');
	$router->get('vip','RechargeController@vip')->name('admin.recharge.vip');
	$router->get('first','RechargeController@first')->name('admin.recharge.first');
});


