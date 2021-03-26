<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \App\User;
use \App\Post;
use \App\Profile;
use \App\Comment;
use \App\Story;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(3)
            ->has(
                Post::factory()->count(3)
                    ->hasLikes(3)
                    ->hasFavorites(3)
                    ->has(
                        Comment::factory()->count(2)
                            ->state(["comment_id" => 0])
                            ->hasLikes(3)
                            ->hasReplies(
                                3,
                                function (array $attributes, Comment $comment) {
                                    return [
                                        "post_id" => $comment->post_id,
                                    ];
                                }
                            )
                    )
            )
            ->has(Story::factory()->count(2)->hasWatchedBy(2))
            ->hasFollowing(2)
            // ->hasComments(2)
            // ->hasWatchedStories(10)
            // ->hasLikePost(10)
            ->create();
    }
}
