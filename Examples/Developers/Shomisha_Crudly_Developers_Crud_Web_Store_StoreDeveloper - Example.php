<?php

public function store(PostRequest $request)
{
    $this->authorize('create', Post::class);
    $post = new Post();
    $post->title = $request->input('title');
    $post->body = $request->input('body');
    $post->published_at = $request->input('published_at');
    $post->save();
    return redirect()->route('posts.index')->with('success', 'Successfully created new instance.');
}