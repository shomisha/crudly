<?php

/**
@test
*/
public function user_can_create_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $data = $this->getPostData(array('title' => 'New Title', 'body' => 'New Body'));
    $response = $this->post(route('posts.store'), $data);
    $response->assertStatus(201);
    $this->assertDatabaseHas('posts', array('title' => 'New Title', 'body' => 'New Body'));
}