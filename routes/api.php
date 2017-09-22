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
    // 所有未读通知
    $api->get('un_read_notifys', 'NotificationController@unReadNotifications');
    // 所有通知
    $api->get('all_notifys', 'NotificationController@notifications');
    // 所有通知设置为已读
    $api->get('notifys_as_read', 'NotificationController@markNotifysAsRead');
    // 获取菜单
    $api->get('menus', 'MenuController@menus');
    // 更新用户
    $api->post('update_user/{user}', 'UsersController@update');
    //上传用户头像
    $api->post('upload', 'UsersController@uploadFile');
    // 根据学院id获取该学院下的所有用户 默认根据当前登陆用户所在学院
    $api->get('users', 'UsersController@usersWithCollege');
    // 任务详情
    //$api->get('task_detail/{task}', 'TaskController@getTaskDetail');
    // 显示某个任务详情  ?include=task_progresses ?college=1  显示各个学院的完成情况
    $api->get('task/{task}', 'TaskController@task');

    //学院
    $api->group(['middleware' => ['role:college']], function ($api) {
        // 添加责任人
        $api->post('create_allot_task/{task}/{college}', 'TaskProgressController@allotTask');
        // 学院显示的任务列表
        $api->get('lists/{college?}', 'TaskController@getTasksByCollege');
    });

    //老师
    $api->group(['middleware' => ['role:teacher']], function ($api) {
        // 学院显示的任务列表
        $api->get('tasks_of_teacher', 'TaskController@getTasksByTeacher');
    });

    //管理员
    $api->group(['middleware' => ['role:super_admin']], function ($api) {
        // 创建任务
        $api->post('create_task', 'TaskController@createTask');
        // 修改任务
        $api->post('update_task/{task_id}', 'TaskController@updateTask');
        // 提交任务
        $api->post('submit_task/{task}/{college}', 'TaskController@submitTask');
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
        // 任务评分
        //$api->post('task_score/{task_id}', 'TaskController@taskScore');
        // 任务提醒
        $api->post('remind/{task}/{college}', 'TaskController@remind');
        // 获取任务的催交记录
        $api->get('reminds/{task}/{college}', 'TaskController@getReminds');
        // 任务列表 ?only_trashed=0|1  ?status=draft|publish
        $api->get('tasks', 'TaskController@tasks');
        // 显示某个任务的进程情况
        $api->get('task_progress/{task_id}', 'TaskProgressController@show');
        // 获取工作类型
        $api->get('work_types', 'WorkTypeController@lists');
        // 获取考核等级
        $api->get('appraises', 'AssessController@lists');
        // 获取学院
        $api->get('colleges', 'CollegeController@lists');
        // 获取对口科室
        $api->get('departments', 'DepartmentController@lists');
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
        // 创建用户
        $api->post('user', 'UsersController@store');
        // 获取指定用户的信息
        $api->get('user/{user}', 'UsersController@show');
        // 删除用户
        $api->get('delete_user/{user}', 'UsersController@destroy');
        // 获取所有角色(不分页 用于添加用户时显示)
        $api->get('roles/all', 'RoleController@allRoles');
        // 角色列表
        $api->get('roles', 'RoleController@lists');
        // 获取指定角色的信息
        $api->get('role/{role}', 'RoleController@show');
        $api->get('role/{role}/permissions', 'RoleController@permissions');
        // todo 封印的功能
        // 创建角色
        $api->post('create_role', 'RoleController@store');
        // 更新角色
        $api->post('update_role/{role}', 'RoleController@update');
        // 删除角色
        $api->get('delete_role/{role}', 'RoleController@destroy');
        // 获取所有权限(不分页 用于创建角色时显示)
        $api->get('permissions/all', 'PermissionsController@allPermissions');
        //获取指定权限
        $api->get('permission/{permission}', 'PermissionsController@show');
        // todo 封印的功能
        // 创建权限
        $api->post('create_permission', 'PermissionsController@store');
        // 更新权限
        $api->post('update_permission/{permission}', 'PermissionsController@update');
        //删除指定权限
        $api->get('delete_permission/{permission}', 'PermissionsController@destroy');
        // 用户列表
        $api->get('all_users', 'UsersController@lists');
        // 获取用户角色
        $api->get('user/{user}/roles', 'UsersController@roles');
    });
});
