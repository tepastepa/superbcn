<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IncrementPostViews
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if ($request->route('post')) {
            $post = $request->route('post');
            if (!session()->has('viewed_post_' . $post->id)) {
                $post->incrementViews();
                session()->put('viewed_post_' . $post->id, true);
            }
        }

        return $response;
    }
} 