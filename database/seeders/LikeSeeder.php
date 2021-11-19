<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    use WithFaker;

    public function run()
    {
        $users = User::all();
        $articles = Article::all()->random(50);
        $replies = Reply::all()->random(50);
        $threads = Thread::all()->random(50);

        DB::beginTransaction();
        foreach ($articles as $article) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $article->likedBy($user);
            }
        }
        DB::commit();

        DB::beginTransaction();
        foreach ($replies as $reply) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $reply->likedBy($user);
            }
        }
        DB::commit();

        DB::beginTransaction();
        foreach ($threads as $thread) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $thread->likedBy($user);
            }
        }
        DB::commit();
    }
}
