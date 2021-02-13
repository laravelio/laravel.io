<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        Article::factory()->count(50)->create([
            'author_id' => 1,
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);

        Article::factory()->count(20)->create([
            'author_id' => 1,
            'submitted_at' => now(),
        ]);
    }
}
