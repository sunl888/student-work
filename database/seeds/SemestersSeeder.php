<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemestersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('semesters')->insert([
            [
                'title' => '2016-2017',
                'semester' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'title' => '2016-2017',
                'semester' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'title' => '2017-2018',
                'semester' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],[
                'title' => '2017-2018',
                'semester' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],]);
    }
}
