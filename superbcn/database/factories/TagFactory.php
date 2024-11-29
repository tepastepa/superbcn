<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        $categories = [
            'Tech', 'Gaming', 'Art', 'Music', 'Food', 'Travel', 
            'Sports', 'Fashion', 'Science', 'Books', 'Movies', 
            'Photography', 'Design', 'Business', 'Health'
        ];

        $subcategories = [
            'News', 'Tips', 'Reviews', 'Guides', 'Trends', 
            'Ideas', 'Basics', 'Advanced', 'Projects', 'Discussion'
        ];

        return [
            'name' => fake()->randomElement($categories) . ' ' . 
                     fake()->randomElement($subcategories)
        ];
    }
} 