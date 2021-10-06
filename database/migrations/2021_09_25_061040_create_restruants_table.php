<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestruantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('email_1');
            $table->string('email_2')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('town_id');
            $table->foreignId('restaurant_operator_id')->constrained()->onDelete('CASCADE')->onUpdate('NO ACTION');
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
        Schema::dropIfExists('restaurants');
    }
}
