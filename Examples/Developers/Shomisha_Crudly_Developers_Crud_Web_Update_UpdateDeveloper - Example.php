<?php

public function update(PostRequest $request, Post $post)
{
    $this->authorize('update', $post);
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->published_at = $request->input('published_at');
    $post->update();
    return redirect()->route('posts.index')->with('success', 'Successfully updated instance.');
}