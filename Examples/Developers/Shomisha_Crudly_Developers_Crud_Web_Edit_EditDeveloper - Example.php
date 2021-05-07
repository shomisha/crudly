<?php

public function edit(Post $post)
{
    $this->authorize('update', $post);
    return view('posts.edit', array('post' => $post));
}