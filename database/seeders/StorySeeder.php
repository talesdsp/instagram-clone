<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Story::factory()
            ->count(20)
            ->hasWatchedBy(2)
            ->create();
    }
}
