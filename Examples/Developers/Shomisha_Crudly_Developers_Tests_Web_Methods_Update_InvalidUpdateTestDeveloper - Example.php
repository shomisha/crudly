<?php

/**
@test
@dataProvider invalidPostDataProvider
*/
public function user_cannot_update_posts_using_invalid_data(string $field, $value)
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create(array('title' => 'Old Title', 'body' => 'Old Body'));
    $data = $this->getPostData(array($field => $value));
    $response = $this->from(route('posts.index'))->put(route('posts.update', $post), $data);
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHasErrors($field);
    $post->refresh();
    $this->assertEquals('Old Title', $post->title);
    $this->assertEquals('Old Body', $post->body);
}