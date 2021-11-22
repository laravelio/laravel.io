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
        $articles = Article::all()->random(100);
        $replies = Reply::all()->random(50);
        $threads = Thread::all()->random(50);
        $likes = [];

        foreach ($articles as $article) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $likes[] = [
                    'likeable_id' => $article->id,
                    'likeable_type' => 'articles',
                    'user_id' => $user->id,
                ];
            }
        }

        foreach ($replies as $reply) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $likes[] = [
                    'likeable_id' => $reply->id,
                    'likeable_type' => 'replies',
                    'user_id' => $user->id,
                ];
            }
        }

        foreach ($threads as $thread) {
            foreach ($users->random(rand(1, 10)) as $user) {
                $likes[] = [
                    'likeable_id' => $thread->id,
                    'likeable_type' => 'threads',
                    'user_id' => $user->id,
                ];
            }
        }

        DB::table('likes')->insert($likes);
    }
}
