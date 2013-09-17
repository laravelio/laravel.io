<?php

Route::get('/', 'Controllers\HomeController@getIndex');

Route::get('login', 'Controllers\AuthController@getLogin');
Route::get('logout', 'Controllers\AuthController@getLogout');
Route::get('oauth', 'Controllers\AuthController@getOauth');