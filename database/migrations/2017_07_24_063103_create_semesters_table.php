<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selemesters', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('title',10)->comment('学期：2016-2017');
            $blueprint->integer('semester')->comment('第几学期：1，2');
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
        Schema::dropIfExists('selemeters');
    }
}
