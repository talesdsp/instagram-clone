<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Post::factory()
        ->count(20)
        ->forLikes(10)
        ->forFavorites(3)
        ->hasComments(5)
            // ->count(5)
            // ->for(\App\User::factory()->create())
            ->create();
    }
}
