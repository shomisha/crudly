<?php

use App\Models\Post;

$posts = Post::factory()->count(5)->create();