<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_name')->default('')->comment('游戏名称');
            $table->string('game_url')->default('')->comment('游戏地址');//循环的时候用来判断菜单是否显示
            $table->string('game_thumb_img')->default('')->comment('游戏缩略图');
            $table->string('appid')->default('')->comment('');
            $table->string('appsecret')->default('')->comment('');
            $table->integer('cp_uid')->default(0)->comment('游戏发布商户id');
            $table->tinyInteger('sort')->unsigned()->default(0)->comment('排序');
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
        //
    }
}
