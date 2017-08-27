<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 每个学院的任务进展情况
        Schema::create('task_progresses', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->integer('task_id')->comment('任务id');
            $blueprint->integer('college_id')->comment('学院id');
            $blueprint->string('user_id')->nullable()->comment('责任人');
            $blueprint->integer('assess_id')->nullable()->comment('考核等级');
            $blueprint->dateTime('status')->nullable()->comment('完成状态(完成时间)');
            $blueprint->string('quality')->nullable()->comment('完成质量');
            $blueprint->string('remark')->nullable()->comment('备注');
            $blueprint->string('delay')->nullable()->comment('推迟理由');
            $blueprint->dateTime('remind')->nullable()->comment('提醒记录');
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
        Schema::dropIfExists('task_progresses');
    }
}
