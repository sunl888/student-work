<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'xsc',
                'password' => bcrypt('xsc'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => null,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 2,
                'name' => 'jsj',
                'password' => bcrypt('jsj'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 9,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 3,
                'name' => 'fxy',
                'password' => bcrypt('fxy'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 6,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],[
                'id' => 4,
                'name' => 'mks',
                'password' => bcrypt('mks'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 8,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 5,
                'name' => 'sunlong',
                'password' => bcrypt('sunlong'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 9,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 6,
                'name' => 'wqer',
                'password' => bcrypt('wqer'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 9,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 7,
                'name' => 'lisi',
                'password' => bcrypt('lisi'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 8,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 8,
                'name' => 'wangwu',
                'password' => bcrypt('wangwu'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 8,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 9,
                'name' => 'lili',
                'password' => bcrypt('lili'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 6,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 10,
                'name' => 'zz',
                'password' => bcrypt('zz'),
                'email' => 'test' . random_int(1, 99) . '@qq.com',
                'college_id' => 6,
                'department_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}