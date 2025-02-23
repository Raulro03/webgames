<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/


use App\Models\Character;
use App\Models\ForumCategory;
use App\Models\Post;
use App\Models\Statistics;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use function Pest\Laravel\actingAs;

uses(TestCase::class, LazilyRefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

function loginAsUser(?User $user = null)
{
    $user = $user ?? User::factory()->create();

    actingAs($user);

    return $user;
}

function ConfirmRolesExist(): void
{
    if (!Role::where('name', 'user')->exists()) {
        Role::create(['name' => 'user']);
    }

    if (!Role::where('name', 'admin')->exists()) {
        Role::create(['name' => 'admin']);
    }

    if (!Role::where('name', 'author')->exists()) {
        Role::create(['name' => 'author']);
    }
}

function CreateUser_ForumCategory(): void
{
    User::factory()->create();
    ForumCategory::factory()->create();


}

function CreateUserAuth_Post()
{
    $user = User::factory()->create();

    loginAsUser($user);

    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    return $post;
}
function CreateUser_Post()
{
    $user = User::factory()->create();

    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    return $post;
}

function CreateCharactersWithStats()
{
    Character::factory()->create([
        'name' => 'Character 1',
    ]);
    Character::factory()->create([
        'name' => 'Character 2',
    ]);
    Statistics::factory()->create([
        'character_id' => 1,
        'constitution' => 3,
        'strength' => 6,
        'agility' => 7,
        'intelligence' => 8,
        'charisma' => 9,
    ]);
    Statistics::factory()->create([
        'character_id' => 2,
        'constitution' => 3,
        'strength' => 6,
        'agility' => 7,
        'intelligence' => 8,
        'charisma' => 9,
    ]);

    $char1 = Character::with('statistics')->first();
    $char2 = Character::with('statistics')->skip(1)->first();

    return [$char1, $char2];
}

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}
