<?php

/**
@test
*/
public function unauthorized_user_cannot_update_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $post = Post::factory()->create(array('title' => 'Old Title', 'body' => 'Old Body'));
    $data = $this->getPostData(array('title' => 'New Title', 'body' => 'New Body'));
    $response = $this->put(route('posts.update', $post), $data);
    $response->assertForbidden();
    $post->refresh();
    $this->assertEquals('Old Title', $post->title);
    $this->assertEquals('Old Body', $post->body);
}