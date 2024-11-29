<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Meilisearch\Client;
use App\Models\Tag;

class PostController extends Controller
{

    public function create()
    {
        // Return a view to create a new post
        return view('posts.create'); // Adjust the view path as necessary
    }
    
    public function index(Request $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            $posts = Post::search($request->search)
                ->query(function ($builder) {
                    $builder->with(['user', 'likes', 'tags'])
                        ->where('expires_at', '>', now())
                        ->latest();
                })
                ->get();
        } else {
            $posts = Post::with(['user', 'likes', 'tags'])
                ->where('expires_at', '>', now())
                ->latest()
                ->get();
        }

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->incrementViews();
        return view('posts.show', compact('post'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            $posts = Post::with(['user', 'likes', 'tags'])
                ->latest()
                ->get();
        } else {
            $posts = Post::search($query)
                ->query(function ($builder) {
                    $builder->with(['user', 'likes', 'tags']);
                })
                ->get();
        }

        if ($request->wantsJson()) {
            $html = view('posts._posts', ['posts' => $posts])->render();
            return response()->json(['html' => $html]);
        }

        return view('posts.index', compact('posts'));
    }

    public function instantSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        $posts = Post::search($query, function (Client $client) {
            // Configure instant search options
            return $client->index('posts')->updateSettings([
                'searchableAttributes' => ['title'],
                'displayedAttributes' => ['*'],
                'pagination' => ['maxTotalHits' => 100],
                'prefix' => ['title']
            ]);
        })
        ->query(function ($builder) {
            $builder->with(['user', 'likes', 'tags']);
        })
        ->get();

        $html = view('posts._posts', ['posts' => $posts])->render();
        return response()->json(['html' => $html]);
    }

    public function edit(Post $post)
    {
        // Check if user is authorized to edit this post
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user is authorized to update this post
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string'
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content']
        ]);

        // Handle tags if they exist
        if (isset($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));
            $tags = collect($tagNames)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName]);
            });
            $post->tags()->sync($tags->pluck('id'));
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string'
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id()
        ]);

        // Handle tags if they exist
        if (isset($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', $validated['tags']));
            $tags = collect($tagNames)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName]);
            });
            $post->tags()->sync($tags->pluck('id'));
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }
}