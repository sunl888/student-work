<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api->post('login', 'LoginController@login');
$api->group(['middleware' => 'auth:web'], function ($api) {
    $api->get('me', 'UsersController@me');
    $api->get('logout', 'LoginController@logout');
    $api->post('create_task', 'TaskController@createTask')->name('create_task');
    $api->get('tasks', 'TaskController@tasks')->name('tasks');
});