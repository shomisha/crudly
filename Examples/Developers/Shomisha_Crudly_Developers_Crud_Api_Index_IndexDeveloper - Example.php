<?php

public function index()
{
    $this->authorize('viewAny', Post::class);
    $posts = Post::paginate();
    return PostResource::collection($posts);
}