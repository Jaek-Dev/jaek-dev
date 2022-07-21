<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\PostComment;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostComment>
 */
class PostCommentFactory extends Factory
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
            'parent_id' => $faker->randomElement([null, ...PostComment::limit(50)->orderBy('id', 'DESC')->get()->pluck('id')]),
            'post_id' => $faker->randomElement(Post::limit(10)->orderBy('id', 'DESC')->get()->pluck('id')),
            'author' => $faker->name(),
            'email' => $faker->email(),
            'website' => $faker->randomElement([null, $faker->url()]),
            'comment' => $faker->realText(\mt_rand(100, 255)),
            'created_at' => \now(),
            'updated_at' => \now(),
        ];
    }
}
