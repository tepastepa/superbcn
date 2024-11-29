<nav class="bg-white border-b border-gray-100 fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('posts.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown - Simplified to just the avatar -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                         alt="{{ Auth::user()->name }}" 
                         class="h-8 w-8 rounded-full object-cover border-2 border-gray-100">
                </a>
            </div>
        </div>
    </div>
</nav>
