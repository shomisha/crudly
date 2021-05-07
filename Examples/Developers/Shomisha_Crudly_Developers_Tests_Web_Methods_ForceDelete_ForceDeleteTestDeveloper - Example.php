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
    $response->assertRedirect(route('posts.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('posts', array('id' => $post->id));
}