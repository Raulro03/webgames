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
        Comment::factory(20)->state(function () {
            return [
                'post_id' => Post::inRandomOrder()->first()->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ];
        })->create()->each(function ($comment) {
            // Asignar un parent_id aleatorio o dejarlo en null
            $parentComment = Comment::where('post_id', $comment->post_id)->inRandomOrder()->first();
            $comment->parent_id = rand(0, 1) ? ($parentComment ? $parentComment->id : null) : null;
            $comment->save();
        });
    }
}
