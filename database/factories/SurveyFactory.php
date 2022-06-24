<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'image' => null, 
            'score' => 1500,   
            'expire_date' => $this->faker->dateTimeBetween('-1 week', '+3 week'),
            'user_id' => $this->faker->numberBetween(1, 2)
        ];
    }
}
