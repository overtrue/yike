<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug', 50)->unique();
            $table->unsignedInteger('creator_id')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->integer('taggable_id');
            $table->string('taggable_type')->index();

            $table->timestamps();

            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::table('tags', function ($table) {
            $table->dropForeign('tags_creator_id_foreign');
        });

        Schema::table('taggables', function ($table) {
            $table->dropForeign('taggables_tag_id_foreign');
        });

        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
}
