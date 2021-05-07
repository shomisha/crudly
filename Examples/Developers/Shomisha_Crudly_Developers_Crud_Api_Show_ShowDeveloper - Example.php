<?php

public function show(Post $post)
{
    $this->authorize('view', $post);
    return new PostResource($post);
}