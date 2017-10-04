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
                'name' => 'admin',
                'password' => bcrypt('admin'),
                'email' => 'test@e8net.cn',
                'college_id' => null,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'name' => 'jsj',
                'password' => bcrypt('jsj'),
                'email' => 'test@e8net.cn',
                'college_id' => 9,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ], [
                'name' => 'sunlong',
                'password' => bcrypt('sunlong'),
                'email' => 'test@e8net.cn',
                'college_id' => 9,
                'picture' => null,
                'gender' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

    }
}