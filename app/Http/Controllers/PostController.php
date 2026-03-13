<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function show(string $slug)
    {
        return view('posts.show');
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
            'author' => ['required', 'string', 'max:255'],
            'content' =>['required', 'string']
        ]);

        $post = new Post();

        $post->title = $parameters['title'];
        $post->slug = $parameters['slug'];
        $post->author = $parameters['author'];
        $post->content = $parameters['content'];

        $post->save();

        return redirect()->route('posts.index');
    }
}
