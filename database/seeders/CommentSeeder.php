<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $parentComment = Comment::factory()->state([
                'post_id' => $post->id,
                'user_id' => User::where('id', '!=', 2)->inRandomOrder()->first()->id,
                'parent_id' => null,
            ])->create();

            Comment::factory(2)->state([
                'post_id' => $post->id,
                'user_id' => User::where('id', '!=', 2)->inRandomOrder()->first()->id,
                'parent_id' => $parentComment->id,
            ])->create();
        }

    }
}
