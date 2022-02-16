<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->nullable();
            $table->foreignId('post_id')->constrained('posts','id')->onDelete('cascade')->onUpdate('no action');
            $table->enum('status',['reported','accepted','deleted'])->default('accepted');
            $table->longText('comment_body');
            $table->integer('reply_count')->default(0);
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
        Schema::dropIfExists('comments');
    }
}
