<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class CleanupExpiredPosts extends Command
{
    protected $signature = 'posts:cleanup';
    protected $description = 'Delete expired posts with insufficient likes';

    public function handle()
    {
        $posts = Post::where('created_at', '<=', now()->subHours(24))
                    ->whereHas('likes', '<', 10)
                    ->get();

        foreach ($posts as $post) {
            $post->delete();
        }

        $this->info('Expired posts cleaned up successfully.');
    }
} 