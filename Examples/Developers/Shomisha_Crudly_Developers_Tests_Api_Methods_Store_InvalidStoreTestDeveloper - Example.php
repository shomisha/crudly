<?php

/**
@test
@dataProvider invalidPostDataProvider
*/
public function user_cannot_create_new_posts_using_invalid_data(string $field, $value)
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $data = $this->getPostData(array($field => $value));
    $response = $this->post(route('posts.store'), $data);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors($field);
    $this->assertDatabaseCount('posts', 0);
}