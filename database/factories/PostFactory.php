<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\PostCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'category_id' => $faker->randomElement(PostCategory::limit(10)->orderBy('id', 'DESC')->get()->pluck('id')),
            'author_id' => $faker->randomElement(User::limit(10)->orderBy('id', 'DESC')->get()->pluck('id')),
            'type' => $faker->randomElement(['blog', 'project']),'title' => $faker->realText(\mt_rand(120, 150)),
            'slug' => $faker->slug((\mt_rand(10, 15))),
            'content' => $faker->paragraph(\mt_rand(100, 110)),
            'photo' => $faker->url(),
            'views' => $faker->randomElement(\range(0, 100)),
            'tags' => implode(',', explode(' ', $faker->sentence(\mt_rand(3, 10)))),
            'source_code_url' => $faker->url(),
            'preview_url' => $faker->url(),
            'created_at' => \now(),
            'updated_at' => \now(),
        ];
    }
}
