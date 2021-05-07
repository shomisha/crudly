<?php

public function index()
{
    $this->authorize('viewAny', Post::class);
    $posts = Post::paginate();
    return view('posts.index', array('posts' => $posts));
}