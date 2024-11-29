<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $createdAt = fake()->dateTimeBetween('-23 hours', 'now');
        
        return [
            'title' => fake()->sentence(rand(4, 8)),
            'content' => fake()->paragraphs(rand(3, 7), true),
            'user_id' => User::factory(),
            'views' => fake()->numberBetween(0, 1000),
            'created_at' => $createdAt,
            'expires_at' => \Carbon\Carbon::parse($createdAt)->addHours(24),
        ];
    }
} 