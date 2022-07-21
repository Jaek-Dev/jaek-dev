<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
        $faker = \fake();
        return [
            'username' => $faker->username(),
            'email' => $faker->email(),
            'password' => Hash::make('123456789'),
            'role' => $faker->randomElement(['admin', 'editor']),
            'verified' => $faker->randomElement([true, false]),
            'status' => $faker->randomElement(['active', 'disabled', 'deleted', 'blocked']),
            'verified' => $faker->randomElement([true, false]),
            'created_at' => \now(),
            'last_seen' => null,
            'last_login' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    // public function unverified()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'email_verified_at' => null,
    //         ];
    //     });
    // }
}
