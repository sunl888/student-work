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
// 登陆
$api->post('login', 'LoginController@login');

$api->group(['middleware' => 'auth:web'], function ($api) {
    // 获取当前用户信息
    $api->get('me', 'UsersController@me');
    // 退出登陆
    $api->get('logout', 'LoginController@logout');
    // 创建任务
    $api->post('create_task', 'TaskController@createTask')->name('create_task');
    // 修改任务
    $api->post('update_task/{task_id}', 'TaskController@updateTask')->name('update_task');
    // 软删除任务
    $api->get('get_task/{task_id}', 'TaskController@getTask');
    // 恢复任务
    $api->post('restore_task/{task_id}', 'TaskController@restoreTask');
    // 审核任务
    $api->post('audit_task/{task_id}', 'TaskController@auditTask');
    // 添加责任人
    $api->post('allot_task', 'TaskController@allotTask')->name('allot_task');
    // 完成任务 如果该任务过了截止日期需要填写推迟理由字段（delay）
    $api->post('submit_task/{task_id}', 'TaskController@submitTask');
    // 判断指定的任务是否过了截止日期 return bool
    $api->get('is_delay/{task_id}', 'TaskController@isDelay');
    // 任务评分
    $api->post('task_score/{task_id}', 'TaskController@taskScore');

    // 获取工作类型
    $api->get('work_types', 'WorkTypeController@lists');
    // 获取考核等级
    $api->get('assess', 'AssessController@lists');
    // 获取学院
    $api->get('colleges', 'CollegeController@lists');
    // 获取对口科室
    $api->get('departments', 'DepartmentController@lists');
    // 根据当前登陆用户获取其所在学院下的所有用户
    $api->get('users', 'UsersController@usersWithCollege');
    // 显示某个任务的进程情况
    $api->get('task_progress/{task_id}', 'TaskProgressController@show');

    // 预置数据的添加、修改、删除(角色：超级管理员)
    $api->group(['middleware' => ['role:super_admin']], function ($api) {
        // 工作类型
        $api->post('create_work_type', 'WorkTypeController@store');
        $api->post('update_work_type/{work_id}', 'WorkTypeController@update');
        $api->get('get_work_type/{work_id}', 'WorkTypeController@get');
        // 考核等级
        $api->post('assess', 'AssessController@store');
        $api->get('assess/{assess_id}', 'AssessController@get');
        $api->post('assess/{assess_id}', 'AssessController@update');
        // 学院
        $api->post('departments', 'DepartmentController@store');
        $api->post('departments/{department_id}', 'DepartmentController@update');
        $api->get('departments/{department_id}', 'DepartmentController@get');
        // 对口科室
        $api->post('colleges', 'CollegeController@store');
        $api->post('colleges/{college_id}', 'CollegeController@update');
        $api->get('colleges/{college_id}', 'CollegeController@get');

    });
});