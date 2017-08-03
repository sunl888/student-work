<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'admin.create_task',
                'display_name' => '创建任务',
                'description' => '创建任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 2,
                'name' => 'admin.edit_task',
                'display_name' => '修改任务',
                'description' => '修改任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 3,
                'name' => 'admin.delete_task',
                'display_name' => '删除任务',
                'description' => '删除任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 4,
                'name' => 'admin.forever_delete_task',
                'display_name' => '永久删除任务',
                'description' => '永久删除任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 5,
                'name' => 'admin.add_person_liable',
                'display_name' => '分配任务给具体的人',
                'description' => '分配任务给具体的人（添加责任人）',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 6,
                'name' => 'admin.submit_task',
                'display_name' => '提交任务',
                'description' => '提交任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 7,
                'name' => 'admin.quality_assessment',
                'display_name' => '质量评价',
                'description' => '质量评价（QA）',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 8,
                'name' => 'admin.audit_task',
                'display_name' => '审核任务',
                'description' => '审核任务',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
