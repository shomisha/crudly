<?php

/**
@test
*/
public function user_can_get_single_post()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->get(route('posts.show', $post));
    $response->assertStatus(200);
    $responsePostId = $response->json('data.id');
    $this->assertEquals($post->id, $responsePostId);
}