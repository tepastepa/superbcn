<div class="bg-white rounded-2xl overflow-hidden">
    <!-- Post Header -->
    <div class="px-6 py-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" 
                     alt="{{ $post->user->name }}" 
                     class="h-10 w-10 rounded-full object-cover">
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-900">{{ $post->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            </div>
            
            @if(auth()->id() === $post->user_id)
                <a href="{{ route('posts.edit', $post) }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Post Content -->
    <div class="px-6 py-2">
        <h2 class="text-xl font-semibold text-gray-900">{{ $post->title }}</h2>
        <p class="mt-2 text-gray-600">{{ $post->content }}</p>
        
        @if($post->tags->count() > 0)
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Post Footer -->
    <div class="px-6 py-4 bg-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Like Button -->
                @auth
                    <button onclick="toggleLike({{ $post->id }})" 
                            class="like-button inline-flex items-center {{ $post->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-gray-600' }} hover:text-red-500 transition-colors duration-200"
                            data-post-id="{{ $post->id }}">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="like-count font-medium">{{ $post->likes->count() }}</span>
                    </button>
                @else
                    <div class="inline-flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="font-medium">{{ $post->likes->count() }}</span>
                    </div>
                @endauth

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
            @if(!$post->likes || $post->likes->count() < 10)
                <div class="inline-flex items-center">
                    <div class="countdown-timer-container backdrop-blur-sm rounded-lg w-[90px] h-[60px] flex items-center justify-center">
                        <div class="countdown-timer text-blue-500 text-2xl"
                             style="font-family: 'D-DINCondensed', sans-serif !important; font-weight: 900; font-size: 24spx; letter-spacing: -0.5px;"
                             data-expires="{{ $post->created_at->addHours(24)->timestamp }}"
                             data-likes="{{ $post->likes->count() }}">
                        </div>
                    </div>
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