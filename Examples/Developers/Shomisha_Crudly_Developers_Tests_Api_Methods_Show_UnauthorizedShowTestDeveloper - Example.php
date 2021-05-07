<?php

/**
@test
*/
public function unauthorized_user_cannot_get_single_post()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->get(route('posts.show', $post));
    $response->assertForbidden();
}