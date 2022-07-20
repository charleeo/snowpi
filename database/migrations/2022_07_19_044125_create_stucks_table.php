<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stock_name');
            $table->string('stock_image');
            $table->text('stock_description')->nullable();
            $table->date('arrival_date');
            $table->date('sold_date')->nullable();
            $table->double('cost_price')->default(0.00);
            $table->double('sales_price')->default(0.00);
            $table->double('logistics_cost')->default(0.00);
            $table->double('profit')->default(0.00);
            $table->string('quntity_received')->default(0);
            $table->string('quntity_sold')->default(0);
            $table->string('quntity_left')->default(0);
            $table->foreignId('stock_category_id')->default(0);
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
        Schema::dropIfExists('stocks');
    }
}
