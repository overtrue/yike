<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->index();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();

            // 拓展资料
            $table->string('real_name')->nullable();
            $table->string('signature')->nullable();

            // 状态
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_banned')->default(false)->index();
            $table->boolean('is_verified')->default(false)->index();

            // 数据缓存
            $table->integer('post_cache')->default(0)->index();
            $table->integer('comment_cache')->default(0)->index();
            $table->integer('follower_cache')->default(0)->index();

            // 账户
            $table->string('github_id')->nullable()->index();
            $table->string('linkedin_id')->nullable()->nullable();
            $table->string('twitter_id')->nullable()->nullable();
            $table->string('weibo_url')->nullable()->nullable();

            $table->timestamp('last_active_at')->nullable();

            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
