<?php

/**
@test
*/
public function user_can_update_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create(array('title' => 'Old Title', 'body' => 'Old Body'));
    $data = $this->getPostData(array('title' => 'New Title', 'body' => 'New Body'));
    $response = $this->put(route('posts.update', $post), $data);
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success');
    $post->refresh();
    $this->assertEquals('New Title', $post->title);
    $this->assertEquals('New Body', $post->body);
}