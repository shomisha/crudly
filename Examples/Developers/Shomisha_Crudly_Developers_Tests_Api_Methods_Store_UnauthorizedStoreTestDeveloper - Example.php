<?php

/**
@test
*/
public function unauthorized_user_cannot_create_new_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $data = $this->getPostData(array('title' => 'New Title', 'body' => 'New Body'));
    $response = $this->post(route('posts.store'), $data);
    $response->assertForbidden();
    $this->assertDatabaseCount('posts', 0);
}