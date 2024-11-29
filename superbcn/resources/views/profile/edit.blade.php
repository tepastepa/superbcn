@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Profile Settings Section -->
        <div class="bg-white rounded-2xl p-6">
            <!-- Profile Information Form -->
            @include('profile.partials.update-profile-information-form')

            <!-- Password Update Form -->
            @include('profile.partials.update-password-form')

            <!-- Logout Button -->
            <div class="mt-6 flex justify-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 text-red-600 hover:text-red-700 transition-colors duration-200">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- My Posts Section -->
        <div class="space-y-6 mt-10 mb-20">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900">My Posts</h2>
            </div>
            
            @if($posts->count() > 0)
                <div class="space-y-4">
                    @foreach($posts as $post)
                        @include('posts._post', ['post' => $post])
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-6 text-center text-gray-500">
                    You haven't created any posts yet.
                </div>
            @endif
        </div>
    </div>
@endsection
