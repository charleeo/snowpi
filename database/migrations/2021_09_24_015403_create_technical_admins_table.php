<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('roles',['super_admin','site_admin','site_moderator'])->default('super_admin');
            $table->string('email',225);
            $table->string('phone',12);
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
        Schema::dropIfExists('technical_admins');
    }
}
