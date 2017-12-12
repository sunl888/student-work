<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('college_id')->nullable()->comment('学院id');
            $table->string('phone')->nullable()->comment('手机号码');
            $table->string('picture', 255)->nullable();
            $table->boolean('gender')->comment('性别 false-男 true-女');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
