<?php

$responsePostId = $response->json('data.id');
$this->assertEquals($post->id, $responsePostId);