<?php

/**
@test
*/
public function unauthorized_user_cannot_access_the_edit_post_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->get(route('posts.edit', $post));
    $response->assertForbidden();
}