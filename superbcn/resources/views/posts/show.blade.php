@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="bg-white rounded-2xl hover:shadow-md transition-all duration-200 overflow-hidden">
        <!-- Post Header with Avatar -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        @if($post->user)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" 
                                 alt="{{ $post->user->name }}" 
                                 class="h-10 w-10 rounded-full object-cover border-2 border-gray-100">
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $post->user->name ?? 'Anonymous' }}</p>
                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                @if(auth()->check() && $post->user_id === auth()->id())
                    <div class="flex space-x-2">
                        <a href="{{ route('posts.edit', $post) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Edit</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Post Content -->
        <div class="px-6 pt-2 pb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-3">{{ $post->title }}</h2>
            <p class="text-gray-800 text-base leading-relaxed mb-4">{{ $post->content }}</p>
            
            <!-- Tags -->
            <div class="flex flex-wrap gap-2">
                @if($post->tags && $post->tags->count() > 0)
                    @foreach($post->tags as $tag)
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Post Footer -->
        <div class="px-6 py-4 bg-white border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <!-- Like Button -->
                    <button class="inline-flex items-center text-gray-600 hover:text-red-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-medium">{{ $post->likes->count() }}</span>
                    </button>

                    <!-- Views -->
                    <div class="inline-flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="font-medium">{{ number_format($post->views) }}</span>
                    </div>
                </div>

                <!-- Timer -->
                @if(!$post->likes || $post->likes->count() < 100)
                    <div class="inline-flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium countdown-timer" 
                              data-expires="{{ $post->expires_at ? $post->expires_at->timestamp : now()->addHours(24)->timestamp }}"
                              data-post-id="{{ $post->id }}">
                            Calculating...
                        </span>
                    </div>
                @else
                    <div class="inline-flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Saved</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 