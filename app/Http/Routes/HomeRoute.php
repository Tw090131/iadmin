<?php
$router->get('/','HomeController@index')->name('admin.home.index');
$router->resource('home','HomeController');