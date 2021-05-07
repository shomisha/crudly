<?php

/**
@test
*/
public function unauthorized_user_cannot_get_the_posts_list()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $response = $this->get(route('posts.index'));
    $response->assertForbidden();
}