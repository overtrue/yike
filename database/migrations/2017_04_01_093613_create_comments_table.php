<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');

            // 类型
            $table->enum('type', ['markdown','html'])->default('html')->index();

            // 内容
            $table->text('content');
            $table->text('content_original')->nullable();

            // 状态缓存
            $table->unsignedInteger('vote_cache')->default(0)->index();

            // 是否 ban 掉
            $table->boolean('is_banned')->default(0);
            $table->string('banned_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
