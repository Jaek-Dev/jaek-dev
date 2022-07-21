<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCategory>
 */
class PostCategoryFactory extends Factory
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
        return [
            'parent_id' => $faker->randomElement(PostCategory::limit(20)->orderBy('id', 'DESC')->get()->pluck('id')),
            'author_id' => $faker->randomElement(User::limit(20)->orderBy('id', 'DESC')->get()->pluck('id')),
            'type' => $faker->randomElement(['blog', 'project']),
            'name' => $faker->sentence(\mt_rand(3, 5)),
            'slug' => $faker->unique()->slug((\mt_rand(3, 5))),
            'created_at' => \now(),
            'updated_at' => \now(),
        ];
    }
}
