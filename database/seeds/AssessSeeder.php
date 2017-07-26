<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('assess')->insert([
            [
                'title' => '优秀',
                'score' => 88,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '良好',
                'score' => 78,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '中等',
                'score' => 68,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '不及格',
                'score' => 58,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);
    }
}
