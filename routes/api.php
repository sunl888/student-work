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
    $api->post('create_task', 'TaskController@createTask');
    // 修改任务
    $api->post('update_task/{task_id}', 'TaskController@updateTask');
    // 软删除任务
    $api->get('delete_task/{task_id}', 'TaskController@deleteTask');
    // 恢复任务
    $api->get('restore_task/{task_id}', 'TaskController@restoreTask');
    //强制删除任务
    $api->get('force_delete_task/{task_id}', 'TaskController@forceDeleteTask');
    // 审核任务
    $api->get('audit_task/{task_id}', 'TaskController@auditTask');
    //取消审核
    $api->get('cancel_audit/{task_id}', 'TaskController@cancelAuditTask');
    // 添加责任人
    $api->post('create_allot_task', 'TaskController@allotTask');
    // 完成任务 如果该任务过了截止日期需要填写推迟理由字段（delay）
    $api->post('submit_task/{task_id}', 'TaskController@submitTask');
    // 判断指定的任务是否过了截止日期 return bool
    $api->get('is_delay/{task_id}', 'TaskController@isDelay');
    // 任务评分
    $api->post('task_score/{task_id}', 'TaskController@taskScore');
    // 任务列表
    $api->get('tasks/{limit?}', 'TaskController@tasks');

    // 已删除的任务列表
    $api->get('trashed_tasks/{offset}/{limit?}', 'TaskController@getTrashed');
    // 获取工作类型
    $api->get('work_types', 'WorkTypeController@lists');
    // 获取考核等级
    $api->get('appraises', 'AssessController@lists');
    // 获取学院
    $api->get('colleges', 'CollegeController@lists');
    // 获取对口科室
    $api->get('departments', 'DepartmentController@lists');
    // 根据当前登陆用户获取其所在学院下的所有用户
    $api->get('users', 'UsersController@usersWithCollege');
    // 显示某个任务的进程情况
    $api->get('task_progress/{task_id}', 'TaskProgressController@show');
    // 显示某个任务
    /*$api->get('task/{task}', function (\App\Models\Task $task) {
        return $task;
    });*/
    $api->get('task/{taskId}', 'TaskController@task');
    // 预置数据的添加、修改、删除(角色：超级管理员)
    $api->group(['middleware' => ['role:super_admin']], function ($api) {
        // 工作类型
        $api->post('create_work_type', 'WorkTypeController@store');
        $api->post('update_work_type/{work_id}', 'WorkTypeController@update');
        $api->get('delete_work_type/{work_id}', 'WorkTypeController@delete');
        // 考核等级
        $api->post('create_appraise', 'AssessController@store');
        $api->post('update_appraise/{assess_id}', 'AssessController@update');
        $api->get('delete_appraise/{assess_id}', 'AssessController@delete');
        // 对口科室
        $api->post('create_department', 'DepartmentController@store');
        $api->post('update_department/{department_id}', 'DepartmentController@update');
        $api->get('delete_department/{department_id}', 'DepartmentController@delete');
        // 学院
        $api->post('create_college', 'CollegeController@store');
        $api->post('update_college/{college_id}', 'CollegeController@update');
        $api->get('delete_college/{college_id}', 'CollegeController@delete');
    });
});
