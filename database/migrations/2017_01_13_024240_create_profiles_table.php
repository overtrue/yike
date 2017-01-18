<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->enum('from', ['wechat', 'github', 'google', 'facebook', 'twitter', 'weibo', 'qq', 'linkedin']);
            $table->string('uid');
            $table->string('username')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('location')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->string('access_token')->nullable()->default(null);
            $table->string('access_token_secret')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('profiles', function ($table) {
            $table->dropForeign('profiles_user_id_foreign');
        });

        Schema::drop('profiles');
    }
}
