<?php

/**
@test
*/
public function unauthorized_user_cannot_force_delete_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->delete(route('posts.forceDelete', $post));
    $response->assertForbidden();
    $post->refresh();
    $this->assertNull($post->archived_at);
}