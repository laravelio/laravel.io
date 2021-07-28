<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Thread;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'github_username' => 'driesvints',
            'password' => bcrypt('password'),
            'type' => User::ADMIN,
        ]);

        User::factory()
            ->count(100)
            ->has(Thread::factory()->count(2), 'threadsRelation')
            ->has(
                Article::factory()
                    ->count(2)
                    ->state(
                        new Sequence(
                            [
                                'submitted_at' => now(),
                                'approved_at' => now(),
                                'hero_image' => 'sxiSod0tyYQ',
                            ],
                            ['submitted_at' => now(), 'approved_at' => now()],
                            ['submitted_at' => now()],
                        ),
                    ),
            )
            ->create();

        Article::published()
            ->inRandomOrder()
            ->take(4)
            ->update(['is_pinned' => true]);
    }
}
