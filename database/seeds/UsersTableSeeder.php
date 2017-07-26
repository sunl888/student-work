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
                'password' => bcrypt('xsc2017'),
                'email'=>'test'.random_int(1,99).'@qq.com',
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 2,
                'name' => 'jsj',
                'password' => bcrypt('jsj2017'),
                'email'=>'test'.random_int(1,99).'@qq.com',
                'gender' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'id' => 3,
                'name' => 'sunlong',
                'password' => bcrypt('sunlong'),
                'email'=>'test'.random_int(1,99).'@qq.com',
                'gender' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}