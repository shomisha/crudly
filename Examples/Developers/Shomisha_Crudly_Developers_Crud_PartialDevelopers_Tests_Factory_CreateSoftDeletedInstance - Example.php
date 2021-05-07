<?php

use App\Models\Post;

$post = Post::factory()->create(['archived_at' => now()]);