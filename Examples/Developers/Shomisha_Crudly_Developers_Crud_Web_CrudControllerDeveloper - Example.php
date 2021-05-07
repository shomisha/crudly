<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PostRequest;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = Post::paginate();

        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);
        $post = new Post();

        return view('posts.create', ['post' => $post]);
    }

    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->published_at = $request->input('published_at');
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Successfully created new instance.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->published_at = $request->input('published_at');
        $post->update();

        return redirect()->route('posts.index')->with('success', 'Successfully updated instance.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');
    }

    public function forceDelete(Post $post)
    {
        $this->authorize('forceDelete', $post);
        $post->forceDelete();

        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');
    }

    public function restore($postId)
    {
        $post = Post::query()->withTrashed()->findOrFail($postId);
        $this->authorize('restore', $post);
        $post->restore();

        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');
    }
}