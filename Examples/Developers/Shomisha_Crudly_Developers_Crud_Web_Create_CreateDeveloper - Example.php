<?php

public function create()
{
    $this->authorize('create', Post::class);
    $post = new Post();
    return view('posts.create', array('post' => $post));
}