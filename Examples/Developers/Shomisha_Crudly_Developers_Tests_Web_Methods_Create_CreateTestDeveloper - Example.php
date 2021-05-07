<?php

/**
@test
*/
public function user_can_access_the_create_new_post_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $response = $this->get(route('posts.create'));
    $response->assertSuccessful();
    $response->assertViewIs('posts.create');
}