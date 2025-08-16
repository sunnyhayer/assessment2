<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; 
use App\Models\Category; 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(),
            'user_id' => User::factory(),       // will create a user if none exists
            'category_id' => Category::factory(), // will create a category if none exists
            'is_active' => $this->faker->randomElement(['Yes', 'No']),
        ];
    }
}
