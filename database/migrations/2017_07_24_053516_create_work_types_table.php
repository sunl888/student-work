<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //工作类型表
        Schema::create('work_types', function (Blueprint $blueprint) {
            $blueprint->increments('id');
            $blueprint->string('title', 10)->comment('工作类型：重点工作、常规工作、突发工作、其他工作');
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
        Schema::dropIfExists('work_types');
    }
}
