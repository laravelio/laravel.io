<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->createQuietly([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testing',
            'github_username' => 'driesvints',
            'password' => bcrypt('password'),
            'type' => User::ADMIN,
        ]);

        User::factory()->createQuietly([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'username' => 'janedoe',
            'github_username' => 'janedoe',
            'password' => bcrypt('password'),
            'type' => User::DEFAULT,
        ]);

        DB::beginTransaction();

        User::factory()
            ->count(300)
            ->has(Thread::factory()->count(2), 'threadsRelation')
            ->has(
                Article::factory()
                    ->count(2)
                    ->state(
                        new Sequence(
                            [
                                'submitted_at' => now(),
                                'approved_at' => now(),
                                'hero_image_id' => 'sxiSod0tyYQ',
                            ],
                            ['submitted_at' => now(), 'approved_at' => now()],
                            ['submitted_at' => now()],
                        ),
                    ),
            )
            ->createQuietly();

        Article::factory()->count(10)->createQuietly(['author_id' => $admin->id]);

        DB::commit();

        Article::published()
            ->inRandomOrder()
            ->take(4)
            ->update(['is_pinned' => true]);

        // Block some users...
        $admin->blockedUsers()->sync(range(20, 24));
    }
}
