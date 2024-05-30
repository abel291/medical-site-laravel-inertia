<?php

namespace Database\Factories;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Surgery>
 */
class SurgeryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(2, 3), true);
        return [
            'name' => $title,
            'slug' => Str::slug($title),
            'entry' => fake()->sentence(30, false),
            'image' => "/img/surgeries/surgery-" . rand(1, 5) . ".jpg",
            'thumb' => "/img/surgeries/surgery-" . rand(1, 5) . ".jpg",
            'description' => Helpers::htmlFake(13),
        ];
    }
}
