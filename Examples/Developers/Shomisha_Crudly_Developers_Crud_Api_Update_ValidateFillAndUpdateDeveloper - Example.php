<?php

$post->title = $request->input('title');
$post->body = $request->input('body');
$post->published_at = $request->input('published_at');
$post->update();