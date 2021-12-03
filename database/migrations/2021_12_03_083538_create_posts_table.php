<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment("Post title goes here")->max(225);
            $table->foreignId('sub_category_id')
            ->comment('The ID of the author who made this post');
            $table->text('body')->comment("The post contents");
            $table->enum('status',[0,1,2])->default(0)->comment("0: The post is yet to be approved, 1:post has been approved, 2:post was reported");
            $table->foreignId('author_id');
            $table->integer('comment_counts')->comment("How many comment has this post. ")->nullable();
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
        Schema::dropIfExists('posts');
    }
}
