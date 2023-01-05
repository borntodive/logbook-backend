<?php

namespace Database\Factories;

use App\Models\Diving;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roster>
 */
class RosterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $diving
            = Diving::inRandomOrder()->first();
        return [
            'date' => fake()->dateTime(),
            'type' => fake()->numberBetween(1, 2),
            'diving_id' => $diving->id,
            'note' => fake()->sentences(2, true),
            'cost' => fake()->numberBetween(50, 90),
            'price' => fake()->numberBetween(50, 90),
        ];
    }
}
