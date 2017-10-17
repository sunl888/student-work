<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password = 'admin';
    static $college_id = 1;

    $college_id <= 15 ?: $college_id = 1;

    return [
        'name' => $faker->unique()->userName,
        'email' => $faker->unique()->freeEmail,
        'password' => bcrypt($password),
        'college_id' => $college_id++,
        'picture' => 'images/picture.jpg',//$faker->imageUrl(640, 480),//$faker->image(public_path('uploads'), 480, 480, 'people', false),
        'gender' => $faker->boolean,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()->addDays(3),
        'remember_token' => null,
    ];
});

$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'detail' => $faker->text(300),
        'work_type_id' => random_int(1, 4),
        'department_id' => random_int(1, 5),
        'end_time' => Carbon::tomorrow()->addDays(10),
        'status' => 'draft',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()->addDays(3)
    ];
});

$factory->define(App\Models\Meeting::class, function (Faker\Generator $faker) {
    $users = [
        '11,13,14',
        '6,7,9',
        '16,17,18,19',
        '26,27,29',
        '36,37,38,39',
        '56,57,59',
    ];
    return [
        'title' => $faker->sentence,
        'detail' => $faker->text(200),
        'users' => $users[random_int(1, count($users) - 1)],
        'start_time' => Carbon::now()->addDays(2),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()->addDays(3)
    ];
});
