<?php

namespace Database\Factories;

use App\Profile;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id"=> User::factory(),
            'name'=> substr($this->faker->name(),0,20),
            'bio'=> $this->faker->text(150),
            'url'=>$this->faker->url(),
            'image'=> "profile/9urmwoiffoe8fum8effisehfefjaw98ummffefc4hlw7.jpeg",
        ];
    }
}
