<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'super_admin',
                    'display_name' => '管理员',
                    'description' => '管理员',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                /*[
                    'id' => 2,
                    'name' => 'common_admin',
                    'display_name' => '一般管理员',
                    'description' => '学生处各个对口科室',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],*/
                [
                    'id' => 2,
                    'name' => 'college',
                    'display_name' => '各学院',
                    'description' => '各学院',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => 3,
                    'name' => 'teacher',
                    'display_name' => '各学院老师',
                    'description' => '各学院老师',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
