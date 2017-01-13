<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug', 50)->unique();
            $table->string('description')->nullable()->default(null);

            $table->unsignedInteger('order')->default(0)->index();

            $table->unsignedInteger('user_id')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('categorizables', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->integer('categorizable_id');
            $table->string('categorizable_type')->index();

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')->on('categories')
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
        Schema::table('categories', function ($table) {
            $table->dropForeign('categories_user_id_foreign');
        });

        Schema::table('categorizables', function ($table) {
            $table->dropForeign('categorizables_category_id_foreign');
        });

        Schema::dropIfExists('categories');
        Schema::dropIfExists('categorizables');
    }
}
