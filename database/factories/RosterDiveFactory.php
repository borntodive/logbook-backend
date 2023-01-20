<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roster>
 */
class RosterDiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'date' => fake()->dateTime(),
            'roster_id' => 1,
            'note' => fake()->sentences(2, true),
            'cost' => 0,
            'price' => 0,
        ];
    }
}
