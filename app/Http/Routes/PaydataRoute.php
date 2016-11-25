<?php
/**
 * 用户路由
 */
$router->group(['prefix' => 'paydata'], function($router){
	$router->get('bill','PaydataController@bill')->name('admin.paydata.bill');
	$router->get('payrate','PaydataController@payrate')->name('admin.paydata.payrate');
	$router->get('ltv','PaydataController@ltv')->name('admin.paydata.ltv');
});


