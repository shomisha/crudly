<?php

foreach ($posts as $post) {
    $this->assertContains($post->id, $responsePostIds);
}