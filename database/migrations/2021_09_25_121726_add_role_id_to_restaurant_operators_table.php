<?php

use App\Models\RestaurantRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToRestaurantOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_operators', function (Blueprint $table) {
            $table->foreignId('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_operators', function (Blueprint $table) {
            if(Schema::hasColumn('restaurant_operators','role_id')){
                $table->dropColumn('role_id');
            }
        });
    }
}
