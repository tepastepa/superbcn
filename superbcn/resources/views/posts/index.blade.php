@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-2">
        <!-- Search Bar -->
        <div class="mb-8">
            <form action="{{ route('posts.index') }}" method="GET" class="relative flex w-full">
                <!-- Input -->
                <input type="text" 
                       name="search" 
                       placeholder="I'm looking for..." 
                       value="{{ request('search') }}"
                       class="flex-1 bg-white text-gray-900 placeholder-gray-300 pl-5 pr-4 py-2 rounded-tl-full rounded-bl-full focus:ring-blue-200 focus:outline-none border border-gray-300">
                
                <!-- Button -->
                <button type="submit" 
                        class="bg-blue-500 text-white px-6 py-2 hover:bg-blue-600 transition-colors duration-200 rounded-tr-full rounded-br-full">
                    Search
                </button>
            </form>
        </div>

        <!-- Posts Container -->
        <div class="space-y-4">
            @foreach($posts as $post)
                @include('posts._post', ['post' => $post])
            @endforeach
        </div>
    </div>
@endsection
