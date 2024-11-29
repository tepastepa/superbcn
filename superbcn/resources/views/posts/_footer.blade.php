<div class="px-6 py-4 bg-white border-t border-gray-100">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <!-- Like Button -->
            <button onclick="toggleLike({{ $post->id }})" 
                    class="like-button inline-flex items-center {{ $post->likes->contains('user_id', auth()->id()) ? 'text-red-500' : 'text-gray-600' }} hover:text-red-500 transition-colors duration-200"
                    data-post-id="{{ $post->id }}">
                <svg class="w-5 h-5 mr-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span class="like-count font-medium">{{ $post->likes->count() }}</span>
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
                      data-expires="{{ $post->created_at->addHours(24)->timestamp }}"
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