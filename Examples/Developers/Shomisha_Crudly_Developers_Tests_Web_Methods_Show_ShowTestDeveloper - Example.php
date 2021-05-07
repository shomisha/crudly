<?php

/**
@test
*/
public function user_can_access_the_single_post_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->get(route('posts.show', $post));
    $response->assertSuccessful();
    $response->assertViewIs('posts.show');
    $responsePost = $response->viewData('post');
    $this->assertTrue($post->is($responsePost));
}