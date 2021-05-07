<?php

public function restore($postId)
{
    $post = Post::query()->withTrashed()->findOrFail($postId);
    $this->authorize('restore', $post);
    $post->restore();
    return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');
}