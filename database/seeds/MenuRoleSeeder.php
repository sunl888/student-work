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
            [
                'menu_id' => 1,
                'role_id' => 1,
            ], [
                'menu_id' => 1,
                'role_id' => 2,
            ], [
                'menu_id' => 1,
                'role_id' => 3,
            ], [//任务管理
                'menu_id' => 2,
                'role_id' => 1,
            ], [//添加任务
                'menu_id' => 3,
                'role_id' => 1,
            ], [//任务考核汇总
                'menu_id' => 4,
                'role_id' => 1,
            ], [//用户管理
                'menu_id' => 5,
                'role_id' => 1,
            ], [//用户列表
                'menu_id' => 6,
                'role_id' => 1,
            ], [//添加用户
                'menu_id' => 7,
                'role_id' => 1,
            ], [//工作通知
                'menu_id' => 8,
                'role_id' => 1,
            ], [
                'menu_id' => 8,
                'role_id' => 2,
            ], [
                'menu_id' => 8,
                'role_id' => 3,
            ], [//通知公告
                'menu_id' => 9,
                'role_id' => 1,
            ], [
                'menu_id' => 9,
                'role_id' => 2,
            ], [
                'menu_id' => 9,
                'role_id' => 3,
            ], [//工作讨论
                'menu_id' => 10,
                'role_id' => 1,
            ], [
                'menu_id' => 10,
                'role_id' => 2,
            ], [
                'menu_id' => 10,
                'role_id' => 3,
            ], [//预置数据
                'menu_id' => 11,
                'role_id' => 1,
            ], [//学院名称设置
                'menu_id' => 12,
                'role_id' => 1,
            ], [//工作类型设置
                'menu_id' => 13,
                'role_id' => 1,
            ], [//对口科室设置
                'menu_id' => 14,
                'role_id' => 1,
            ], [//考核等级设置
                'menu_id' => 15,
                'role_id' => 1,
            ], [//学院显示的任务列表
                'menu_id' => 16,
                'role_id' => 2,
            ], [//老师显示的任务列表
                'menu_id' => 17,
                'role_id' => 3,
            ]
        ]);
    }
}
