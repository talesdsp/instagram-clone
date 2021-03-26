<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertFalse;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => substr($this->faker->name, 0, 60),
            'username' => substr($this->faker->unique()->userName,0,20),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->boolean ? now() : null,
            'password' => Hash::make("password"),
        ];
    }
}
