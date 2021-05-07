<?php

public function show(Post $post)
{
    $this->authorize('view', $post);
    return view('posts.show', array('post' => $post));
}