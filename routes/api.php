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
    // 创建任务
    $api->post('create_task', 'TaskController@createTask')->name('create_task');
    //修改任务
    $api->post('update_task/{task_id}', 'TaskController@updateTask')->name('update_task');
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

    /**
     * 预置数据的处理
     */
    //工作类型
    $api->get('work_types', 'WorkTypeController@lists');
    //考核等级
    $api->get('assess', 'AssessController@lists');
    //学院
    $api->get('colleges', 'CollegeController@lists');
    //对口科室
    $api->get('departments', 'DepartmentController@lists');
    //获取当前学院下的所有用户
    $api->get('users', 'UsersController@usersWithCollege');
    //显示某个任务的进程情况
    $api->get('task_progress/{task_id}', 'TaskProgressController@show');

    //预置数据的添加、修改、删除
    $api->group(['middleware' => ['role:super_admin']], function ($api) {
        //工作类型
        $api->post('create_work_type', 'WorkTypeController@store');
        $api->put('update_work_type/{work_id}', 'WorkTypeController@update');
        $api->delete('delete_work_type/{work_id}', 'WorkTypeController@delete');

        //考核等级
        $api->post('assess', 'AssessController@store');
        $api->delete('assess/{assess_id}', 'AssessController@delete');
        $api->put('assess/{assess_id}', 'AssessController@update');

        //学院
        $api->post('departments', 'DepartmentController@store');
        $api->put('departments/{department_id}', 'DepartmentController@update');
        $api->delete('departments/{department_id}', 'DepartmentController@delete');

        //对口科室
        $api->post('colleges', 'CollegeController@store');
        $api->put('colleges/{college_id}', 'CollegeController@update');
        $api->delete('colleges/{college_id}', 'CollegeController@delete');

    });
});