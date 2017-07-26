<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //学生管理、思想教育、学生资助、心理健康、领导交办
        DB::table('departments')->insert([[
            'name' => '学生管理',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => '思想教育',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => '学生资助',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => '心理健康',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => '领导交办',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
