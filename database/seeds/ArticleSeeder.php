<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        factory(Article::class, 50)->create(['author_id' => 1]);
    }
}
