<?php

Route::get('/', 'Controllers\Home@getIndex');

Route::controller('oauth', 'Controllers\Oauth');
