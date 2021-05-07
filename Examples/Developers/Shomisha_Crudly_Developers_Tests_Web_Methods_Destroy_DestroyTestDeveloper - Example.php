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
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success');
    $post->refresh();
    $this->assertNotNull($post->archived_at);
}