<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteExpiredPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete posts that are 24h old and have less than 10 likes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::where('created_at', '<=', Carbon::now()->subHours(24))
                    ->whereHas('likes', '<', 10)
                    ->get();

        foreach ($posts as $post) {
            $post->delete();
        }

        $this->info('Expired posts deleted successfully.');
    }
} 