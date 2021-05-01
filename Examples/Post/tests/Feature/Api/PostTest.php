<?php

namespace Tests\Feature\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Shomisha\Crudly\Exceptions\IncompleteTestException;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function createAndAuthenticateUser() : User
    {
        $user = User::factory()->create();
        $this->be($user);

        return $user;
    }

    private function getPostData(array $override = []) : array
    {
        return array_merge(['title' => 'Dr.', 'body' => 'Autem suscipit quia ut illum repudiandae magni libero. Non quae similique vero sint. Repudiandae nisi suscipit illo omnis iusto a. Recusandae ut perferendis consequatur debitis optio et.

Corporis quisquam at harum ea. Voluptas vel doloremque vero. Qui ipsa doloremque sit doloremque deleniti sit. Inventore repellendus asperiores autem perspiciatis sunt voluptatum debitis.

Exercitationem id ut qui quis. Ipsa distinctio corrupti exercitationem recusandae. Nisi minus aperiam qui omnis. Ipsam ut autem consequatur odio velit repellendus.', 'published_at' => '2015-11-19 00:12:24'], $override);
    }

    private function authorizeUser(User $user) : void
    {
        throw IncompleteTestException::provideUserAuthorization();
    }

    private function deauthorizeUser(User $user) : void
    {
        throw IncompleteTestException::provideUserDeauthorization();
    }

    private function getIndexRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('index');
    }

    private function getShowRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('show');
    }

    private function getStoreRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('store');
    }

    private function getUpdateRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('update');
    }

    private function getDestroyRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('destroy');
    }

    private function getForceDeleteRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('force-delete');
    }

    private function getRestoreRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('restore');
    }

    /**
     * @test
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

    /**
     * @test
     */
    public function unauthorized_user_cannot_get_the_posts_list()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $response = $this->get(route('posts.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_get_single_post()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->get(route('posts.show', $post));
        $response->assertStatus(200);
        $responsePostId = $response->json('data.id');
        $this->assertEquals($post->id, $responsePostId);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_get_single_post()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->get(route('posts.show', $post));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_create_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getPostData(['title' => 'New Title', 'body' => 'New Body']);
        $response = $this->post(route('posts.store'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'New Title', 'body' => 'New Body']);
    }

    public function invalidPostDataProvider()
    {
        return ['Title is not a string' => ['title', false], 'Title is missing' => ['title', null], 'Body is not a string' => ['body', 124], 'Body is missing' => ['body', null], 'Published at is not a date' => ['published_at', 'not a date'], 'Published at is in invalid format' => ['published_at', '21.12.2012. at 21:12'], 'Published at is missing' => ['published_at', null]];
    }

    /**
     * @test
     * @dataProvider invalidPostDataProvider
     */
    public function user_cannot_create_new_posts_using_invalid_data(string $field, $value)
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getPostData([$field => $value]);
        $response = $this->post(route('posts.store'), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_create_new_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $data = $this->getPostData(['title' => 'New Title', 'body' => 'New Body']);
        $response = $this->post(route('posts.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function user_can_update_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create(['title' => 'Old Title', 'body' => 'Old Body']);
        $data = $this->getPostData(['title' => 'New Title', 'body' => 'New Body']);
        $response = $this->put(route('posts.update', $post), $data);
        $response->assertStatus(204);
        $post->refresh();
        $this->assertEquals('New Title', $post->title);
        $this->assertEquals('New Body', $post->body);
    }

    /**
     * @test
     * @dataProvider invalidPostDataProvider
     */
    public function user_cannot_update_posts_using_invalid_data(string $field, $value)
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create(['title' => 'Old Title', 'body' => 'Old Body']);
        $data = $this->getPostData([$field => $value]);
        $response = $this->put(route('posts.update', $post), $data);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
        $post->refresh();
        $this->assertEquals('Old Title', $post->title);
        $this->assertEquals('Old Body', $post->body);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_update_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $post = Post::factory()->create(['title' => 'Old Title', 'body' => 'Old Body']);
        $data = $this->getPostData(['title' => 'New Title', 'body' => 'New Body']);
        $response = $this->put(route('posts.update', $post), $data);
        $response->assertForbidden();
        $post->refresh();
        $this->assertEquals('Old Title', $post->title);
        $this->assertEquals('Old Body', $post->body);
    }

    /**
     * @test
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

    /**
     * @test
     */
    public function unauthorized_user_cannot_delete_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->delete(route('posts.destroy', $post));
        $response->assertForbidden();
        $post->refresh();
        $this->assertNull($post->archived_at);
    }

    /**
     * @test
     */
    public function user_can_force_delete_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->delete(route('posts.forceDelete', $post));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /**
     * @test
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

    /**
     * @test
     */
    public function user_can_restore_soft_deleted_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create(['archived_at' => now()]);
        $response = $this->patch(route('posts.restore', $post));
        $response->assertStatus(204);
        $post->refresh();
        $this->assertNull($post->archived_at);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_restore_soft_deleted_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $post = Post::factory()->create(['archived_at' => now()]);
        $response = $this->patch(route('posts.restore', $post));
        $response->assertForbidden();
        $post->refresh();
        $this->assertNotNull($post->archived_at);
    }
}