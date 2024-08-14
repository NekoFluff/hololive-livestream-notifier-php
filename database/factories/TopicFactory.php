<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firat_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'topic_url' => $this->faker->url,
            'group' => $this->faker->word,
            'generation' => $this->faker->numberBetween(1, 10),
        ];
    }
}
