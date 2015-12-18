<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','PagesController@home');

Route::get('notices/create/confirm', 'NoticesController@confirm');
Route::resource('notices', 'NoticesController');
//Route:resource('notices', 'NoticesController', []); // If you want to remove any Route, it can be passes as third parameter in array

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
