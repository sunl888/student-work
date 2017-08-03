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
    // 创建任务
    $api->post('create_task', 'TaskController@createTask')->name('create_task');
    //软删除任务
    $api->delete('delete_task/{task_id}', 'TaskController@deleteTask');
    //恢复任务
    $api->put('restore_task/{task_id}', 'TaskController@restoreTask');
    //审核任务
    $api->put('audit_task/{task_id}', 'TaskController@auditTask');
    // 添加责任人
    $api->post('allot_task', 'TaskController@allotTask')->name('allot_task');
    // 完成任务
    $api->put('submit_task/{task_id}', 'TaskController@submitTask');
    // 任务评分
    $api->post('task_score/{task_id}', 'TaskController@taskScore');
    //$api->get('tasks', 'TaskController@tasks')->name('tasks');

    //工作类型
    $api->get('work_types', 'WorkTypeController@lists');
    //对口科室
    $api->get('departments', 'DepartmentController@lists');
    //获取当前学院下的所有用户
    $api->get('users', 'UsersController@usersWithCollege');
});