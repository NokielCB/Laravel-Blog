<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
}
