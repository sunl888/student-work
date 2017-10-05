<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++) {
            DB::table('meetings')->insert([
                'id' => $i + 1,
                'title' => str_random(200),
                'detail' => str_random(200),
                'users' => '1,3,4,6,9',
                'start_time' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
