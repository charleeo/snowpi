<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStuckCustomCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_custom_categories', function (Blueprint $table) {
            $table->id();
            $table->string('custom_category_name');
            $table->string('custom_category_slug')->nullable();
            $table->text('custom_category_description')->nullable();
            $table->foreignId('customer_id')->comment('The id of the person that wants this category created for');
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
        Schema::dropIfExists('stock_custom_categories');
    }
}
