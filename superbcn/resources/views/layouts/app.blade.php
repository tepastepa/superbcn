<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            @font-face {
                font-family: 'D-DINCondensed';
                src: url('/D-DINCondensed.otf') format('opentype');
                font-weight: normal;
                font-style: normal;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <!-- Header -->
        <header class="bg-white fixed top-0 w-full z-50 h-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <a href="{{ route('posts.index') }}" class="text-xl font-bold text-gray-900">
                        <img src="{{ asset('logo.svg') }}" alt="Zephyr Logo" class="h-7 w-auto">
                    </a>

                    <!-- Account Navigation -->
                    @auth
                        <a href="{{ route('profile.edit') }}">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                                 alt="Profile" 
                                 class="h-8 w-8 rounded-full object-cover">
                        </a>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Log in</a>
                            <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-900">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="pt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-8">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Floating Create Post Button -->
        <div style="position: fixed; bottom: 40px; left: 50%; transform: translateX(-50%); z-index: 50;">
            <a href="{{ route('posts.create') }}" 
               class="flex items-center px-6 py-3 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Create Post</span>
            </a>
        </div>

        <!-- Scripts -->
        <script>
            // Like functionality
            @auth
            function toggleLike(postId) {
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    const likeButton = document.querySelector(`button[data-post-id="${postId}"]`);
                    if (!likeButton) return;

                    const likeCount = likeButton.querySelector('.like-count');
                    if (!likeCount) return;
                    
                    // Update like count
                    likeCount.textContent = data.likes_count;
                    
                    // Update button color
                    if (data.liked) {
                        likeButton.classList.remove('text-gray-600');
                        likeButton.classList.add('text-red-500');
                    } else {
                        likeButton.classList.remove('text-red-500');
                        likeButton.classList.add('text-gray-600');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            @endauth
        </script>
    </body>
</html>
