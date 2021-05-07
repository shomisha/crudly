<?php

/**
@test
*/
public function users_can_access_the_posts_index_page()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $posts = Post::factory()->count(5)->create();
    $response = $this->get(route('posts.index'));
    $response->assertSuccessful();
    $response->assertViewIs('posts.index');
    $responsePostIds = $response->viewData('posts')->pluck('id');
    $this->assertCount($posts->count(), $responsePostIds);
    foreach ($posts as $post) {
        $this->assertContains($post->id, $responsePostIds);
    }
}