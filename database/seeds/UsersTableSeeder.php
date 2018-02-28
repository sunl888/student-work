<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class   UsersTableSeeder extends Seeder
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
                'nickname' => 'admin',
                'password' => bcrypt('admin2017'),
                'email' => app(Faker\Generator::class)->freeEmail,
                'college_id' => 1,
                'picture' => 'images/picture.jpg',
                'gender' => app(Faker\Generator::class)->boolean,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

    }
}