<?php

namespace Database\Factories;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            "comment_id" => Comment::factory(),
            'text' => $this->faker->text(50),
            'edited' => $this->faker->boolean(),
        ];
    }
}
