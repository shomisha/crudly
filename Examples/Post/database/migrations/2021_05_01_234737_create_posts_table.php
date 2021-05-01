<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->dateTime('published_at');
            $table->softDeletes('archived_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}