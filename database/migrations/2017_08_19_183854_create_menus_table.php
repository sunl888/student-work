<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            //菜单名称
            $table->string('name',20);
            //父级id
            $table->unsignedInteger('parent_id')->default(0);
            //图标
            $table->string('icon');
            //路由
            $table->string('url');
            //描述
            $table->string('description')->nullable();
            //是否在导航栏显示
            $table->boolean('is_nav')->default(true);
            //排序字段
            $table->integer('order')->default(0)->index()->comment('排序字段');
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
        Schema::dropIfExists('menus');
    }
}
