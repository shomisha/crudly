<?php

/**
@test
*/
public function user_can_get_a_list_of_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $posts = Post::factory()->count(5)->create();
    $response = $this->get(route('posts.index'));
    $response->assertStatus(200);
    $responsePostIds = collect($response->json('data'))->pluck('id');
    $this->assertCount($posts->count(), $responsePostIds);
    foreach ($posts as $post) {
        $this->assertContains($post->id, $responsePostIds);
    }
}