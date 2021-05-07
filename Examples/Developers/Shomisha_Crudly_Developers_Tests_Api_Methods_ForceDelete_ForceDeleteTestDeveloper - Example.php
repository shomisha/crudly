<?php

/**
@test
*/
public function user_can_force_delete_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $post = Post::factory()->create();
    $response = $this->delete(route('posts.forceDelete', $post));
    $response->assertStatus(204);
    $this->assertDatabaseMissing('posts', array('id' => $post->id));
}