<?php

namespace Database\Factories;

use App\Models\UserDuty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
         $gender = fake()->randomElements(['male', 'female'])[0];

        return [
            'firstname' => fake()->firstName($gender),
            'lastname' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'cf' => fake()->taxId(),
            'gender'=>$gender,
            'height'=>fake()->numberBetween(150,195),
            'weight'=>fake()->numberBetween(40,120),
            'birthdate' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'remember_token' => Str::random(10),
            'user_duty_id'=> UserDuty::inRandomOrder()->first(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
