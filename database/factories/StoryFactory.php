<?php

namespace Database\Factories;

use App\Story;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Story::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> User::factory(),
            'story'=> "profile/9urmwoiffoe8fum8effisehfefjaw98ummffefc4hlw7.jpeg",
            'type'=>  'image',
        ];
    }
}
