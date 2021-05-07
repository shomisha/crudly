<?php

use App\Models\Post;

$post = Post::query()->withTrashed()->findOrFail($postId);