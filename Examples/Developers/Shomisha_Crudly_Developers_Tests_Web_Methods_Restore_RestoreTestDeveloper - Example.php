<?php

/**
@test
*/
public function user_can_restore_soft_deleted_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create(array('archived_at' => now()));
    $response = $this->patch(route('posts.restore', $post));
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success');
    $post->refresh();
    $this->assertNull($post->archived_at);
}