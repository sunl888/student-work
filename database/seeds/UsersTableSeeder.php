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
                'email' => 'test@e8net.cn',
                'college_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 2,
                'name' => 'jsj',
                'password' => bcrypt('jsj'),
                'email' => 'test@e8net.cn',
                'college_id' => 9,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 3,
                'name' => 'fxy',
                'password' => bcrypt('fxy'),
                'email' => 'test@e8net.cn',
                'college_id' => 6,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 4,
                'name' => 'mks',
                'password' => bcrypt('mks'),
                'email' => 'test@e8net.cn',
                'college_id' => 8,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 5,
                'name' => 'sunlong',
                'password' => bcrypt('sunlong'),
                'email' => 'test@e8net.cn',
                'college_id' => 9,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 6,
                'name' => 'wqer',
                'password' => bcrypt('wqer'),
                'email' => 'test@e8net.cn',
                'college_id' => 9,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 7,
                'name' => 'lisi',
                'password' => bcrypt('lisi'),
                'email' => 'test@e8net.cn',
                'college_id' => 8,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 8,
                'name' => 'wangwu',
                'password' => bcrypt('wangwu'),
                'email' => 'test@e8net.cn',
                'college_id' => 8,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 9,
                'name' => 'lili',
                'password' => bcrypt('lili'),
                'email' => 'test@e8net.cn',
                'college_id' => 6,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ], [
                'id' => 10,
                'name' => 'zz',
                'password' => bcrypt('zz'),
                'email' => 'test@e8net.cn',
                'college_id' => 6,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now()->addMinutes(random_int(1,59)),
                'updated_at' => Carbon::now()->addMinutes(random_int(1,59))
            ]
        ]);
    }
}