<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestSeeder extends Seeder
{
    public function run()
    {
        Log::info('Starting test seeder');
        try {
            DB::connection()->getPdo();
            Log::info('Database connected successfully');
            
            $userCount = DB::table('users')->count();
            $postCount = DB::table('posts')->count();
            
            Log::info("Current counts - Users: {$userCount}, Posts: {$postCount}");
        } catch (\Exception $e) {
            Log::error('Database error: ' . $e->getMessage());
        }
    }
} 