<?php

/**
@test
@dataProvider invalidPostDataProvider
*/
public function user_cannot_create_posts_using_invalid_data(string $field, $value)
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $data = $this->getPostData(array($field => $value));
    $response = $this->from(route('posts.index'))->post(route('posts.store'), $data);
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHasErrors($field);
    $this->assertDatabaseCount('posts', 0);
}