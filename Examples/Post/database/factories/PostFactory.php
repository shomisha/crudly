<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return ['title' => $this->faker->text(255), 'body' => $this->faker->text(63000), 'published_at' => $this->faker->dateTime()];
    }
}