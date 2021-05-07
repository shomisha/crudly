<?php

use App\Models\Post;

$post = new Post();
$post->title = $request->input('title');
$post->body = $request->input('body');
$post->published_at = $request->input('published_at');
$post->save();