<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //学期
        Schema::create('semesters', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('title', 10)->comment('学期区间：2016-2017');
            $blueprint->integer('semester')->comment('具体学期：1，2');
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semesters');
    }
}
