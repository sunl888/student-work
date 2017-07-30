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
    //$api->post('create_task', ['middleware' => ['ability:super_admin|common_admin,admin.create_task,true'],'uses'=>'TaskController@createTask'])->name('create_task');
    $api->post('create_task','TaskController@createTask')->name('create_task');
    $api->post('allot_task', 'TaskController@allotTask')->name('allot_task');
    // 完成任务
    $api->post('submit_task/{task_id}', 'TaskController@submitTask');
    $api->get('tasks', 'TaskController@tasks')->name('tasks');
});