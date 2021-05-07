<?php

$responsePost = $response->viewData('post');
$this->assertTrue($post->is($responsePost));