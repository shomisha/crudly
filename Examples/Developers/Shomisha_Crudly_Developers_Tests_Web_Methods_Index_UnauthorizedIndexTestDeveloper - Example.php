<?php

/**
@test
*/
public function unauthorized_user_cannot_access_the_posts_index_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $response = $this->get(route('posts.index'));
    $response->assertForbidden();
}