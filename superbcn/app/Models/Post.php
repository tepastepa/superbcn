<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'views',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->expires_at = now()->addHours(24);
            if (!isset($post->views)) {
                $post->views = 0;
            }
        });
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function shouldBeDeleted()
    {
        return $this->expires_at <= now() && $this->likes->count() < 100;
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
        ];
    }

    public function getTimeLeftAttribute()
    {
        return $this->created_at->addHours(24)->timestamp;
    }
} 