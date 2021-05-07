<?php

/**
@test
*/
public function unauthorized_user_cannot_restore_soft_deleted_post()
{
    $user = $this->createAndAuthenticateUser();
    $this->deauthorizeUser($user);
    $post = Post::factory()->create(array('archived_at' => now()));
    $response = $this->patch(route('posts.restore', $post));
    $response->assertForbidden();
    $post->refresh();
    $this->assertNotNull($post->archived_at);
}