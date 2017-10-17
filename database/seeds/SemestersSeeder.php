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
        //学年 学期
        DB::table('semesters')->insert([[
            'id' =>1,
            'title' => '2016/2017',
            'start_time' => '2016/09/01',
            'end_time' => '2017/07/01',
            'parent_id' => 0,
            'checked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'id' =>2,
            'title' => '第一学期',
            'start_time' => '2016/09/01',
            'end_time' => '2017/02/15',
            'parent_id' => 0,
            'checked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'id' =>3,
            'title' => '第二学期',
            'start_time' => '2017/02/16',
            'end_time' => '2017/07/01',
            'parent_id' => 0,
            'checked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'id' =>4,
            'title' => '2017/2018',
            'start_time' => '2017/09/01',
            'end_time' => '2018/07/01',
            'parent_id' => 0,
            'checked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'id' =>5,
            'title' => '第一学期',
            'start_time' => '2017/09/01',
            'end_time' => '2018/02/15',
            'parent_id' => 0,
            'checked' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'id' =>6,
            'title' => '第二学期',
            'start_time' => '2018/02/16',
            'end_time' => '2018/07/01',
            'parent_id' => 0,
            'checked' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
