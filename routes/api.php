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
    // 任务提醒
    $api->post('remind/{task}/{college}', 'TaskController@remind');

    /**
     * 任务查询相关
     */
    // 任务列表[后面可以加查询条件 如：?status=publish]
    $api->get('tasks', 'TaskController@tasks');
    // 已发布任务列表
    $api->get('lists', 'TaskController@getTasksByCollege');
    // 已删除的任务列表
    $api->get('trashed_tasks', 'TaskController@getTrashed');
    // 显示某个任务的进程情况
    $api->get('task_progress/{task_id}', 'TaskProgressController@show');
    // 显示某个任务
    $api->get('task/{taskId}', 'TaskController@task');

    // 根据学院id获取该学院下的所有用户 默认根据当前登陆用户所在学院
    $api->get('users', 'UsersController@usersWithCollege');

    /**
     * 预置数据的获取
     */
    // 获取工作类型
    $api->get('work_types', 'WorkTypeController@lists');
    // 获取考核等级
    $api->get('appraises', 'AssessController@lists');
    // 获取学院
    $api->get('colleges', 'CollegeController@lists');
    // 获取对口科室
    $api->get('departments', 'DepartmentController@lists');

    /**
     * 预置数据的添加、修改、删除(角色：超级管理员)
     */
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

        /**
         * 角色的操作
         */
        // 获取所有角色(不分页 用于添加用户时显示)
        $api->get('roles/all', 'RoleController@allRoles');
        // 角色列表
        $api->get('roles', 'RoleController@lists');
        // 获取指定角色的信息
        $api->get('role/{role}', 'RoleController@show');
        $api->get('role/{role}/permissions', 'RoleController@permissions');
        // todo 【BUG】这里涉及到新角色可以访问那些菜单的问题
        // 分析：用户的操作是由权限决定的，而用户菜单的显示和权限之间没有联系导致可能出现用户可以显示某个菜单但没有权限进行菜单内的操作
        // 解决办法：角色暂时写死，不提供create、update、delete功能
        // 创建角色
        //$api->post('create_role', 'RoleController@store');
        // 更新角色
        //$api->post('update_role/{role}', 'RoleController@update');
        // 删除角色
        //$api->get('delete_role/{role}', 'RoleController@destroy');

        /**
         * 权限的操作
         */
        // 获取所有权限(不分页 用于创建角色时显示)
        $api->get('permissions/all', 'PermissionsController@allPermissions');
        //获取指定权限
        $api->get('permission/{permission}', 'PermissionsController@show');
        // 创建权限
        $api->post('create_permission', 'PermissionsController@store');
        // 更新权限
        $api->post('update_permission/{permission}', 'PermissionsController@update');
        //删除指定权限
        $api->get('delete_permission/{permission}', 'PermissionsController@destroy');


        /**
         * 用户相关
         */
        // 用户列表
        $api->get('all_users', 'UsersController@lists');
        // 创建用户
        $api->post('user', 'UsersController@store');
        // 获取指定用户的信息
        $api->get('user/{user}', 'UsersController@show');
        // 更新用户
        $api->post('update_user/{user}', 'UsersController@update');
        // 删除用户
        $api->get('delete_user/{user}', 'UsersController@destroy');
        // 获取用户角色
        $api->get('user/{user}/roles', 'UsersController@roles');
    });

    /**
     * 通知
     */
    // 所有未读通知
    $api->get('un_read_notifys', 'NotificationController@unReadNotifications');
    // 所有通知
    $api->get('all_notifys', 'NotificationController@notifications');
    // 所有通知设置为已读
    $api->get('notifys_as_read', 'NotificationController@markNotifysAsRead');

    /**
     * 菜单
     */
    // 获取菜单
    $api->get('menus', 'MenuController@menus');


});
