<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_id')->nullable()->default(null);
            $table->unsignedInteger('order')->default(0)->index();
            $table->unsignedInteger('image_id');
            $table->string('title')->nullable()->index();
            $table->string('link')->nullable();
            $table->string('target')->default('_blank')->index();
            $table->text('description')->nullable();

            // 启用时间
            $table->timestamp('enabled_at')->nullable();
            // 过期时间
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
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
        Schema::dropIfExists('banners');
    }
}
