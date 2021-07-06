<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class LikeSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        $users = User::all();
        $articles = Article::all();
        $replies = Reply::all();
        $threads = Thread::all();

        $articles->random(100)->each(function ($article) use ($users) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $article->likedBy($user);
            }
        });

        $replies->random(50)->each(function ($reply) use ($users) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $reply->likedBy($user);
            }
        });

        $threads->random(50)->each(function ($thread) use ($users) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $thread->likedBy($user);
            }
        });
    }
}
