<?php

namespace Database\Factories;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::factory(),
            'caption' => $this->faker->text(100),
            'image'=> "profile/9urmwoiffoe8fum8effisehfefjaw98ummffefc4hlw7.jpeg",
        ];
    }
}
