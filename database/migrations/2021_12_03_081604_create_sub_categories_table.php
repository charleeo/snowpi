<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('sub_categories')){
            Schema::drop('sub_categories');
        }
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('sub_category_name')->max(225);
            $table->foreignId('category_id')->constrained()->onDelete("CASCADE")->onUpdate('NO ACTION');
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
        Schema::dropIfExists('sub_categories');
    }
}
