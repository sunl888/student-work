<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('title', 10)->comment('任务标题');
            $blueprint->string('detail')->comment('任务详情');
            //$blueprint->string('person_liable')->comment('责任人');
            $blueprint->integer('work_type_id')->comment('工作类型');
            $blueprint->integer('department_id')->comment('对口科室');
            $blueprint->timestamp('created_at')->comment('创建时间');
            $blueprint->dateTime('end_time')->comment('结束时间');
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
        Schema::dropIfExists('tasks');
    }
}
