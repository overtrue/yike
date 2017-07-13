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
            $table->unsignedInteger('credit_cache')->default(0)->index();
            $table->unsignedInteger('post_cache')->default(0)->index();
            $table->unsignedInteger('comment_cache')->default(0)->index();
            $table->unsignedInteger('follower_cache')->default(0)->index();
            $table->unsignedInteger('view_cache')->default(0)->index();

            // 账户
            $table->string('github_id')->nullable()->index();
            $table->string('linkedin_id')->nullable()->index();
            $table->string('twitter_id')->nullable()->index();
            $table->string('weibo_url')->nullable()->index();

            $table->timestamp('last_active_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
