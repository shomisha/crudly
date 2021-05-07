<?php

/**
@test
*/
public function user_can_access_the_edit_post_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->get(route('posts.edit', $post));
    $response->assertSuccessful();
    $response->assertViewIs('posts.edit');
    $responsePost = $response->viewData('post');
    $this->assertTrue($post->is($responsePost));
}