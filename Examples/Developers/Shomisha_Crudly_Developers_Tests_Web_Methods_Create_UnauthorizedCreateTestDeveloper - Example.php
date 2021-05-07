<?php

/**
@test
*/
public function unauthorized_user_cannot_visit_the_create_new_post_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $response = $this->get(route('posts.create'));
    $response->assertForbidden();
}