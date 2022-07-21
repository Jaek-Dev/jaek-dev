<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //Get faker instance
        $faker = \fake();

        //Create a user
        User::factory()->count(1)->create();

        //Then use the id of the last user to populate the user data table
        return [
            'user_id' => $faker->randomElement(User::limit(1)->orderBy('id', 'DESC')->get()->pluck('id')),
            'first_name' => $faker->name(1),
            'middle_name' => $faker->name(1),
            'last_name' => $faker->name(1),
            'date_of_birth' => $faker->date(),
            'gender' => $faker->randomElement(['male', 'female']),
            'photo' => Str::random(\mt_rand(10, 20)) . $faker->randomElement(['.jpg', '.jpeg', '.png', '.gif']),
            'apartment' => $faker->sentence(1),
            'address' => $faker->address(),
            'zip_code' => $faker->postcode(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'country' => $faker->country(),

            // 'product_id',
            // 'category_id' => $faker->randomElement([null]),
            // 'shop_id' => $faker->randomElement([null]),
            // 'brand_id' => $faker->randomElement([null]),
            // 'discount' => $faker->randomElement(\range(0, 100)),
            // 'sizes' => $faker->randomElement(['L,XL', 'XXS, XXL, M, S', null]),
            // 'colors'=> $faker->randomElement([null, '#857374', '#093847', '#fa84ad']),
            // 'tags' => \str_replace(' ', ',', $faker->sentence(\mt_rand(5, 10))),
            // 'views'  => $faker->randomElement([\range(0, 1000, \mt_rand(1, 20))]),
            // 'overview' => $faker->sentence(\mt_rand(250, 500)),
            // 'description' => $faker->sentence(\mt_rand(1000, 2500)),
        ];
    }
}
