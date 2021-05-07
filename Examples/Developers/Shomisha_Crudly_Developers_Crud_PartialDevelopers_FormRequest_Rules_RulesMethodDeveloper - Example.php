<?php

public function rules()
{
    $titleUniqueRule = Rule::unique('posts', 'title');
    $post = $this->route('post');
    if ($post) {
        $titleUniqueRule->ignore($post->id);
    }
    return array('title' => array($titleUniqueRule, 'required', 'string', 'max:255'), 'body' => array('required', 'string', 'max:65535'), 'published_at' => array('required', 'date_format:Y-m-d H:i:s'));
}