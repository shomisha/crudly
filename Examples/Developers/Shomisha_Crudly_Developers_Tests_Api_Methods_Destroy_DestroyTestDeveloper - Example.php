<?php

/**
@test
*/
public function user_can_delete_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->delete(route('posts.destroy', $post));
    $response->assertStatus(204);
    $post->refresh();
    $this->assertNotNull($post->archived_at);
}