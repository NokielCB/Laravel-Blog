<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function myPosts(Request $request)
    {
        $isAdmin = (bool) $request->user()->is_admin;

        $posts = $isAdmin
            ? Post::with('user')->latest()->paginate(10)
            : $request->user()->posts()->latest()->paginate(10);

        return view('dashboard', [
            'posts' => $posts,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $posts = Post::with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->get();

        return view('posts.index', [
            'posts' => $posts,
            'search' => $search,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::with([
            'user',
            'topLevelComments.user',
            'topLevelComments.likes',
            'topLevelComments.replies.user',
            'topLevelComments.replies.likes',
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'lead' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('posts', 'public');
        }

        Post::create([
            'title' => $parameters['title'],
            'slug' => $parameters['slug'],
            'lead' => $parameters['lead'] ?? null,
            'content' => $parameters['content'],
            'photo' => $photoPath,
            'is_published' => $request->boolean('is_published'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $post->id],
            'lead' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'is_published' => ['nullable', 'boolean'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('remove_photo') && $post->photo) {
            Storage::disk('public')->delete($post->photo);
            $parameters['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
            }

            $parameters['photo'] = $request->file('photo')->store('posts', 'public');
        }

        $post->update([
            'title' => $parameters['title'],
            'slug' => $parameters['slug'],
            'lead' => $parameters['lead'] ?? null,
            'content' => $parameters['content'],
            'photo' => $parameters['photo'] ?? $post->photo,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('post_saved', 'Post zostal zaktualizowany.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()
            ->route('dashboard')
            ->with('post_deleted', 'Post zostal usuniety.');
    }
}
