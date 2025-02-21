<?php

use App\Jobs\DeleteOldArchivedPosts;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;

it('deletes archived posts older than 5 years', function () {

    CreatePost_ForumCategory();
    // 🔹 Crear posts de prueba
    $oldPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'status' => 'archived',
        'published_at' => Carbon::now()->subYears(6),
    ]);

    $recentPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'status' => 'archived',
        'published_at' => Carbon::now()->subYears(3),
    ]);

    $unarchivedPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'status' => 'published',
        'published_at' => Carbon::now()->subYears(7),
    ]);

    // 🔹 Ejecutar el Job manualmente
    (new DeleteOldArchivedPosts())->handle();

    // 🔹 Verificar que el post antiguo se eliminó
    expect(Post::find($oldPost->id))->toBeNull();

    // 🔹 Verificar que el post reciente y el no archivado no se eliminaron
    expect(Post::find($recentPost->id))->not->toBeNull();
    expect(Post::find($unarchivedPost->id))->not->toBeNull();
});

it('logs deleted posts', function () {
    CreatePost_ForumCategory();

    Log::spy();

    $oldPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'status' => 'archived',
        'published_at' => Carbon::now()->subYears(6),
    ]);

    (new DeleteOldArchivedPosts())->handle();

    Log::shouldHaveReceived('info')->withArgs(function ($message) use ($oldPost) {
        return str_contains($message, "Eliminando post archivado: {$oldPost->id}");
    });
});

/*it('has jobs\deleteoldarchivedposts page', function () {
    $response = $this->get('/jobs\deleteoldarchivedposts');

    $response->assertStatus(200);
});*/

