<?php

/**
@test
*/
public function user_can_create_new_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $data = $this->getPostData(array('title' => 'New Title', 'body' => 'New Body'));
    $response = $this->post(route('posts.store'), $data);
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('posts', array('title' => 'New Title', 'body' => 'New Body'));
}