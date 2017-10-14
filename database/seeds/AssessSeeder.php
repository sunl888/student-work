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
                'type' => 'examines',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '良好',
                'score' => 78,
                'type' => 'examines',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '中等',
                'score' => 68,
                'type' => 'examines',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '不及格',
                'score' => 58,
                'type' => 'examines',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '外出',
                'score' => -8,
                'type' => 'lates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '出差',
                'score' => 0,
                'type' => 'lates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '病假',
                'score' => -2,
                'type' => 'lates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '事假',
                'score' => -6,
                'type' => 'lates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '其他',
                'score' => -4,
                'type' => 'lates',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);
    }
}
