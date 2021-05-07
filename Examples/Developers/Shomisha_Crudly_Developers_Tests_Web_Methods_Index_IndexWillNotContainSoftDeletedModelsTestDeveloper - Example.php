<?php

/**
@test
*/
public function index_page_will_not_contain_soft_deleted_posts()
{
    $user = $this->createAndAuthenticateUser();
    $this->authorizeUser($user);
    $posts = Post::factory()->count(5)->create();
    $post = Post::factory()->create(array('archived_at' => now()));
    $response = $this->get(route('posts.index'));
    $response->assertSuccessful();
    $response->assertViewIs('posts.index');
    $responsePostIds = $response->viewData('posts')->pluck('id');
    $this->assertNotContains($post->id, $responsePostIds);
}