<?php

public function destroy(Post $post)
{
    $this->authorize('delete', $post);
    $post->delete();
    return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');
}