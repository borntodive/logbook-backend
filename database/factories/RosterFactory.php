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
        $type = fake()->randomElement(['POOL', 'DIVE']);
        $cost = 0;
        if ($type == 'DIVE')
            $cost = fake()->numberBetween(50, 90);
        $price = $cost + ($cost * (10 / 100));
        return [
            'date' => fake()->dateTime(),
            'type' => $type,
            'diving_id' => $diving->id,
            //'note' => fake()->sentences(2, true),
            //'cost' => $cost,
            //'price' => $price,
        ];
    }
}
