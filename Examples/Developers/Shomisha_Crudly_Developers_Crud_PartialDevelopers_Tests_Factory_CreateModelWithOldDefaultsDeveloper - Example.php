<?php

use App\Models\Post;

$post = Post::factory()->create(['title' => 'Old Title', 'body' => 'Old Body']);