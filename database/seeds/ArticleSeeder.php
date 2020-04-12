<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        factory(Article::class, 50)->create([
            'author_id' => 1,
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);
    }
}
