<?php

public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title')->unique();
        $table->text('body');
        $table->timestamp('published_at');
        $table->softDeletes('archived_at');
        $table->timestamps();
    });
}