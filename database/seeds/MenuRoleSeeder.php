<?php

use Illuminate\Database\Seeder;

class MenuRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_role')->insert([
            [// parent任务管理
                'menu_id' => 1,
                'role_id' => 1,
            ], [
                'menu_id' => 1,
                'role_id' => 2,
            ], [
                'menu_id' => 1,
                'role_id' => 3,
            ], [// 任务管理
                'menu_id' => 2,
                'role_id' => 1,
            ], [// 创建任务
                'menu_id' => 3,
                'role_id' => 1,
            ], [// parent用户管理
                'menu_id' => 4,
                'role_id' => 1,
            ], [
                'menu_id' => 4,
                'role_id' => 2,
            ], [
                'menu_id' => 4,
                'role_id' => 3,
            ], [// 用户列表
                'menu_id' => 5,
                'role_id' => 1,
            ], [// 创建用户
                'menu_id' => 6,
                'role_id' => 1,
            ], [// 修改用户信息
                'menu_id' => 7,
                'role_id' => 1,
            ], [
                'menu_id' => 7,
                'role_id' => 2,
            ], [
                'menu_id' => 7,
                'role_id' => 3,
            ], [// parent通知公告
                'menu_id' => 8,
                'role_id' => 1,
            ], [
                'menu_id' => 8,
                'role_id' => 2,
            ], [
                'menu_id' => 8,
                'role_id' => 3,
            ], [// 工作通知
                'menu_id' => 9,
                'role_id' => 1,
            ], [
                'menu_id' => 9,
                'role_id' => 2,
            ], [
                'menu_id' => 9,
                'role_id' => 3,
            ], [// 预置数据
                'menu_id' => 10,
                'role_id' => 1,
            ],[
                'menu_id' => 11,
                'role_id' => 1,
            ],[
                'menu_id' => 12,
                'role_id' => 1,
            ],[
                'menu_id' => 13,
                'role_id' => 1,
            ],[
                'menu_id' => 14,
                'role_id' => 1,
            ], [// 任务列表
                'menu_id' => 15,
                'role_id' => 2,
            ],[// 任务列表
                'menu_id' => 16,
                'role_id' => 3,
            ], [// 会议管理
                'menu_id' => 17,
                'role_id' => 1,
            ], [
                'menu_id' => 17,
                'role_id' => 2,
            ], [
                'menu_id' => 17,
                'role_id' => 3,
            ], [
                'menu_id' => 18,
                'role_id' => 1,
            ],[
                'menu_id' => 18,
                'role_id' => 2,
            ],[
                'menu_id' => 18,
                'role_id' => 3,
            ], [// 创建会议
                'menu_id' => 19,
                'role_id' => 1,
            ], [// 任务汇总
                'menu_id' => 20,
                'role_id' => 1,
            ], [// 任务汇总
                'menu_id' => 21,
                'role_id' => 1,
            ], [// 图标显示
                'menu_id' => 22,
                'role_id' => 1,
            ]
        ]);
    }
}
