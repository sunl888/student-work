<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('colleges')->insert([
            [
                'title' => '化工与材料工程学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '文学与传播学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '生物工程学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '教育学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '电子工程学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '法学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '机械与电气工程学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '马克思主义学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '计算机学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '外国语学院（大学外语教学部）',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '经济与管理学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '体育学院（公共体育教学部）',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '金融学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '音乐与舞蹈学院（少儿舞蹈研究中心）',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'title' => '美术与设计学院',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);
    }
}
