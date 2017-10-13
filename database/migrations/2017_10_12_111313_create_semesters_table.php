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
        Schema::create('semesters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); //2016-2017
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->unsignedInteger('parent_id')->default(0);// 0->学年
            $table->boolean('checked')->default(0);
            $table->timestamps();
            $table->softDeletes();
            /*$table->foreign('parent_id')
                ->references('id')->on('semesters')
                ->onDelete('cascade');*/
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
