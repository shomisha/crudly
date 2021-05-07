<?php

public function restore($postId)
{
    $post = Post::query()->withTrashed()->findOrFail($postId);
    $this->authorize('restore', $post);
    $post->restore();
    return response()->noContent();
}