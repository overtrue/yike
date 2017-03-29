<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 系列表
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');

            // 专栏头像
            $table->unsignedInteger('image_id')->nullable();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description')->nullable();

            // 数据缓存
            $table->unsignedInteger('post_cache')->default(0)->index();
            $table->unsignedInteger('follower_cache')->default(0)->index();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        // 系列文章关系表
        Schema::create('series_post', function (Blueprint $table) {
            $table->unsignedInteger('series_id');
            $table->unsignedInteger('post_id');

            $table->foreign('series_id')->references('id')->on('series')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['series_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('series');
        Schema::dropIfExists('series_post');
    }
}
