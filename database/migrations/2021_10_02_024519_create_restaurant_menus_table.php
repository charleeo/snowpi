<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_menus', function (Blueprint $table) {
            $table->id();
            $table->string('menu_name');
            $table->string('menu_guid');
            $table->double('price')->default(0.00);
            $table->double('promo_price')->default(0.00);
            $table->text('menu_description');
            $table->text("menu_images");
            $table->enum('menu_status',['available','not-available'])->default('available');
            $table->string('restaurant_id');
            $table->string('promo_code')->nullable();
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
        Schema::dropIfExists('restaurant_menus');
    }
}
