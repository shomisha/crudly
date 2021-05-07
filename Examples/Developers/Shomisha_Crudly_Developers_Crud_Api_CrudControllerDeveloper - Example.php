<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = Post::paginate();

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return new PostResource($post);
    }

    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->published_at = $request->input('published_at');
        $post->save();

        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->published_at = $request->input('published_at');
        $post->update();

        return response()->noContent();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->noContent();
    }

    public function forceDelete(Post $post)
    {
        $this->authorize('forceDelete', $post);
        $post->forceDelete();

        return response()->noContent();
    }

    public function restore($postId)
    {
        $post = Post::query()->withTrashed()->findOrFail($postId);
        $this->authorize('restore', $post);
        $post->restore();

        return response()->noContent();
    }
}