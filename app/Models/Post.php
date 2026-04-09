<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'user_id',
        'photo',
        'is_published',
    ];

    /**
     * Get the user who wrote this post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->where('status', 'approved')
            ->latest();
    }

    public function topLevelComments()
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->latest();
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
