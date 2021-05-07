<?php

public function destroy(Post $post)
{
    $this->authorize('delete', $post);
    $post->delete();
    return response()->noContent();
}