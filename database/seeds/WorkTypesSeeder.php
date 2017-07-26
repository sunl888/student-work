<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WorkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //重点工作、常规工作、突发工作、其他工作
        DB::table('work_types')->insert([
            [
                'title' => '重点工作',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '常规工作',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '突发工作',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '其他工作',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);
    }
}
