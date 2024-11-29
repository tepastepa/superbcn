<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Log::info('Starting database seeder');
        
        try {
            // Create users
            $users = User::factory(10)->create();
            Log::info('Created users: ' . $users->count());

            // Create tags
            $tags = Tag::factory(15)->create();
            Log::info('Created tags: ' . $tags->count());

            // Create posts
            Log::info('Starting to create posts...');
            
            $totalPosts = 0;
            foreach ($users as $user) {
                Log::info('Creating posts for user: ' . $user->id);
                
                $posts = Post::factory()->count(5)->create([
                    'user_id' => $user->id,
                    'created_at' => now()->subHours(rand(1, 23)),
                    'expires_at' => now()->addHours(24)
                ]);
                
                $totalPosts += $posts->count();
                Log::info('Created ' . $posts->count() . ' posts for user ' . $user->id);

                foreach ($posts as $post) {
                    // Add tags
                    $tagCount = rand(1, 4);
                    $post->tags()->attach($tags->random($tagCount));
                    Log::info('Added ' . $tagCount . ' tags to post ' . $post->id);

                    // Add likes
                    $likeCount = rand(0, 10);
                    $randomUsers = $users->random(min($likeCount, $users->count()));
                    foreach ($randomUsers as $randomUser) {
                        Like::create([
                            'user_id' => $randomUser->id,
                            'post_id' => $post->id,
                            'created_at' => now()->subMinutes(rand(1, 1440))
                        ]);
                    }
                    Log::info('Added ' . $likeCount . ' likes to post ' . $post->id);
                }
            }

            Log::info('Seeding completed. Total posts created: ' . $totalPosts);
            Log::info('Final post count in database: ' . Post::count());
            
        } catch (\Exception $e) {
            Log::error('Seeding error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }
} 