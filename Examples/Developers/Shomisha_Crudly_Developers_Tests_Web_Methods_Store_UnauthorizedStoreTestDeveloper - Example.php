<?php

/**
@test
*/
public function unauthorized_users_cannot_crete_new_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $data = $this->getPostData();
    $response = $this->post(route('posts.store'), $data);
    $response->assertForbidden();
    $this->assertDatabaseCount('posts', 0);
}