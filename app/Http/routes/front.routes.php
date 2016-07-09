<?php

/***************    Site routes  **********************************/
Route::get('/', ['as' => 'home', 'middleware'=>'redirectAdmin', 'uses' => 'Frontend\HomeController@index']);
Route::get('home', 'Frontend\HomeController@index');

# Authentication
Route::get('/auth/login', ['as' => 'login', 'middleware' => ['guest'], 'uses' => 'Auth\SessionsController@create']);
Route::get('/auth/logout', ['as' => 'logout', 'uses' => 'Auth\SessionsController@destroy']);
Route::any('/auth/store', ['as' => 'auth.store', 'uses' => 'Auth\SessionsController@store']);
Route::any('/auth/create', ['as' => 'auth.create', 'uses' => 'Auth\SessionsController@create']);
Route::any('/auth/destroy', ['as' => 'auth.destroy', 'uses' => 'Auth\SessionsController@destroy']);
//Route::resource('/auth', 'Auth\SessionsController', ['only' => ['create', 'store', 'destroy']]);



# Registration
/*
Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/register', ['as' => 'registration.form', 'uses' => 'RegistrationController@create']);
    Route::post('/auth/register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
});
*/
# Forgotten Password
/*
Route::group(['middleware' => 'guest'], function () {
    Route::get('forgot_password', 'Auth\PasswordController@getEmail');
    Route::post('forgot_password', 'Auth\PasswordController@postEmail');
    Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
});
*/

?>