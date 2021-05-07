<?php

$response = $this->from(route('posts.index'))->put(route('posts.update', $post), $data);