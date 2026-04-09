<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $rules = [
            'content' => ['required', 'string', 'max:3000'],
            'author' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ];

        if (! $request->user()) {
            $rules['author'] = ['required', 'string', 'max:255'];
            $rules['email'] = ['required', 'email', 'max:255'];
        }

        $parameters = $request->validate($rules);

        $parentId = $parameters['parent_id'] ?? null;

        if ($parentId !== null) {
            $parentComment = Comment::query()
                ->where('id', $parentId)
                ->where('post_id', $post->id)
                ->first();

            if (! $parentComment) {
                return redirect()
                    ->route('posts.show', $post->slug)
                    ->withErrors(['content' => 'Wybrany komentarz nadrzedny nie istnieje.'])
                    ->withInput();
            }
        }

        Comment::create([
            'post_id' => $post->id,
            'parent_id' => $parentId,
            'user_id' => $request->user()?->id,
            'author' => $request->user()?->name ?? $parameters['author'],
            'email' => $request->user()?->email ?? $parameters['email'],
            'content' => $parameters['content'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('comment_submitted', 'Komentarz zostal wyslany i czeka na moderacje administratora.');
    }

    public function toggleLike(Request $request, Comment $comment)
    {
        if ($comment->status !== 'approved') {
            abort(404);
        }

        $user = $request->user();

        $alreadyLiked = $comment->likes()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            $comment->likes()->detach($user->id);
        } else {
            $comment->likes()->attach($user->id);
        }

        $comment->update([
            'likes_count' => $comment->likes()->count(),
        ]);

        return back();
    }
}
