<?php

use App\Models\Post;

$this->authorize('viewAny', Post::class);