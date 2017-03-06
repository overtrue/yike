<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->comment('存储路径');
            $table->string('strategy')->nullable()->comment('类型');
            $table->string('mime')->nullable()->comment('MIME 类型');
            $table->boolean('cdn_enabled')->default(false);
            $table->string('title')->comment('文件名');
            $table->json('size')->nullable()->comment('width/height');
            $table->unsignedInteger('creator_id')->comment('创建者');
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
        Schema::dropIfExists('images');
    }
}
