<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = collect([
            $this->createTag('Installation', 'installation'),
            $this->createTag('Blade', 'blade'),
            $this->createTag('Cache', 'cache'),
        ]);

        Article::all()->each(function ($article) use ($tags) {
            $article->syncTags(
                $tags->random(rand(0, $tags->count()))
                    ->pluck('id')
                    ->toArray(),
            );
        });

        Thread::all()->each(function ($article) use ($tags) {
            $article->syncTags(
                $tags->random(rand(0, $tags->count()))
                    ->pluck('id')
                    ->toArray(),
            );
        });
    }

    private function createTag(string $name, string $slug)
    {
        return Tag::factory()->create(compact('name', 'slug'));
    }
}
