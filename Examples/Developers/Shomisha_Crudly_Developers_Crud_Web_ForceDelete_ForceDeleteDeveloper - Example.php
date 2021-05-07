<?php

public function forceDelete(Post $post)
{
    $this->authorize('forceDelete', $post);
    $post->forceDelete();
    return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');
}