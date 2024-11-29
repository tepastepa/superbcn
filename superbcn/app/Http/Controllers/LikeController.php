<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        try {
            $like = $post->likes()->where('user_id', auth()->id())->first();

            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                $post->likes()->create([
                    'user_id' => auth()->id()
                ]);
                $liked = true;
            }

            return response()->json([
                'liked' => $liked,
                'likes_count' => $post->fresh()->likes()->count()
            ]);
            
        } catch (\Exception $e) {
            // If there's an error, return the current state
            return response()->json([
                'liked' => $post->likes()->where('user_id', auth()->id())->exists(),
                'likes_count' => $post->likes()->count()
            ]);
        }
    }
} 