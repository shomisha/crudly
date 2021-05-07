<?php

public function forceDelete(Post $post)
{
    $this->authorize('forceDelete', $post);
    $post->forceDelete();
    return response()->noContent();
}