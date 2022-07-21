<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;
use App\Models\ProductBags;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //Get the faker instance
        $faker = \fake();

        //Create a product
        Products::factory()->count(1)->create();

        //then use the last product id to populate the rest of the stuff
        return [
            'product_id' => $faker->randomElement(Products::limit(1)->orderBy('id', 'DESC')->get()->pluck('id')),
            'category_id' => $faker->randomElement(ProductBags::limit(50)->orderBy('id', 'DESC')->get()->pluck('id')),
            // 'shop_id' => $faker->randomElement([null]),
            // 'brand_id' => $faker->randomElement([null]),
            // 'discount' => $faker->randomElement(\range(0, 100)),
            // 'sizes' => $faker->randomElement(['L,XL', 'XXS, XXL, M, S', null]),
            // 'colors'=> $faker->randomElement([null, '#857374', '#093847', '#fa84ad']),
            // 'tags' => \str_replace(' ', ',', $faker->sentence(\mt_rand(5, 10))),
            // 'views'  => $faker->randomElement([\range(0, 1000, \mt_rand(1, 20))]),
            // 'overview' => $faker->sentence(\mt_rand(250, 500)),
            'description' => $faker->paragraph(\mt_rand(100, 250)),
        ];
    }
}
