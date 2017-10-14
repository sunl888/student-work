<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 缺勤者
        Schema::create('absentees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('meeting_id');
            $table->unsignedInteger('assess_id');
            $table->string('remark')->nullable(); //其他原因
            $table->timestamps();
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('assess_id')->references('id')->on('assess');
//            $table->foreign('meeting_id')->references('id')->on('meetings');// ->onDelete('cascade')->onUpdate('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absentees');
    }
}
