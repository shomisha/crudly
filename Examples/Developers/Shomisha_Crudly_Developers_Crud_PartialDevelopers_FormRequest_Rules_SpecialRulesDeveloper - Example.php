<?php

use Illuminate\Validation\Rule;

$titleUniqueRule = Rule::unique('posts', 'title');
$post = $this->route('post');
if ($post) {
    $titleUniqueRule->ignore($post->id);
}