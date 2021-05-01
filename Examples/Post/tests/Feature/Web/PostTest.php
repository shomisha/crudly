<?php

namespace Tests\Feature\Web;

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
        return array_merge(['title' => 'Mr.', 'body' => 'Est in aut nam repellendus eum ducimus. Quam ut fugit molestiae optio et et. A quia quo aliquid deleniti qui quam. Consequatur natus voluptatem voluptatem.

Qui eum deserunt et ea. Nulla ea eveniet molestias nesciunt illum. Exercitationem maiores quo et sit tenetur ab eum.

Qui cum aperiam rerum soluta incidunt quisquam. Sed id provident explicabo omnis doloremque sit. Autem rerum maxime vel et.', 'published_at' => '1975-08-31 11:26:41'], $override);
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

    private function getCreateRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('create');
    }

    private function getStoreRoute() : string
    {
        throw IncompleteTestException::missingRouteGetter('store');
    }

    private function getEditRoute(Post $post) : string
    {
        throw IncompleteTestException::missingRouteGetter('edit');
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

    /**
     * @test
     */
    public function index_page_will_not_contain_soft_deleted_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $posts = Post::factory()->count(5)->create();
        $post = Post::factory()->create(['archived_at' => now()]);
        $response = $this->get(route('posts.index'));
        $response->assertSuccessful();
        $response->assertViewIs('posts.index');
        $responsePostIds = $response->viewData('posts')->pluck('id');
        $this->assertNotContains($post->id, $responsePostIds);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_access_the_posts_index_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $response = $this->get(route('posts.index'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_access_the_single_post_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->get(route('posts.show', $post));
        $response->assertSuccessful();
        $response->assertViewIs('posts.show');
        $responsePost = $response->viewData('post');
        $this->assertTrue($post->is($responsePost));
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_access_the_post_single_page()
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
    public function user_can_access_the_create_new_post_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $response = $this->get(route('posts.create'));
        $response->assertSuccessful();
        $response->assertViewIs('posts.create');
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_visit_the_create_new_post_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $response = $this->get(route('posts.create'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function user_can_create_new_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getPostData(['title' => 'New Title', 'body' => 'New Body']);
        $response = $this->post(route('posts.store'), $data);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');
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
    public function user_cannot_create_posts_using_invalid_data(string $field, $value)
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $data = $this->getPostData([$field => $value]);
        $response = $this->from(route('posts.index'))->post(route('posts.store'), $data);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHasErrors($field);
        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function unauthorized_users_cannot_crete_new_posts()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $data = $this->getPostData();
        $response = $this->post(route('posts.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function user_can_access_the_edit_post_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->authorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->get(route('posts.edit', $post));
        $response->assertSuccessful();
        $response->assertViewIs('posts.edit');
        $responsePost = $response->viewData('post');
        $this->assertTrue($post->is($responsePost));
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_access_the_edit_post_page()
    {
        $user = $this->createAndAuthenticateUser();
        $this->deauthorizeUser($user);
        $post = Post::factory()->create();
        $response = $this->get(route('posts.edit', $post));
        $response->assertForbidden();
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
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');
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
        $response = $this->from(route('posts.index'))->put(route('posts.update', $post), $data);
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHasErrors($field);
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
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');
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
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');
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
        $response->assertRedirect(route('posts.index'));
        $response->assertSessionHas('success');
        $post->refresh();
        $this->assertNull($post->archived_at);
    }

    /**
     * @test
     */
    public function unauthorized_user_cannot_restore_soft_deleted_post()
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