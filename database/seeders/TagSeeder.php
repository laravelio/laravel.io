<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => 'Installation', 'slug' => 'installation'],
            ['name' => 'Configuration', 'slug' => 'configuration'],
            ['name' => 'Authentication', 'slug' => 'authentication'],
            ['name' => 'Security', 'slug' => 'security'],
            ['name' => 'Requests', 'slug' => 'requests'],
            ['name' => 'Input', 'slug' => 'input'],
            ['name' => 'Session', 'slug' => 'session'],
            ['name' => 'Cache', 'slug' => 'cache'],
            ['name' => 'Database', 'slug' => 'database'],
            ['name' => 'Eloquent', 'slug' => 'eloquent'],
            ['name' => 'IOC', 'slug' => 'ioc'],
            ['name' => 'Views', 'slug' => 'views'],
            ['name' => 'Blade', 'slug' => 'blade'],
            ['name' => 'Forms', 'slug' => 'forms'],
            ['name' => 'Validation', 'slug' => 'validation'],
            ['name' => 'Mail', 'slug' => 'mail'],
            ['name' => 'Queues', 'slug' => 'queues'],
            ['name' => 'Laravel.io', 'slug' => 'laravelio'],
            ['name' => 'Packages', 'slug' => 'packages'],
            ['name' => 'Meetups', 'slug' => 'meetups'],
            ['name' => 'Architecture', 'slug' => 'architecture'],
            ['name' => 'Jobs', 'slug' => 'jobs'],
            ['name' => 'Testing', 'slug' => 'testing'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Lumen', 'slug' => 'lumen'],
            ['name' => 'Spark', 'slug' => 'spark'],
            ['name' => 'Forge', 'slug' => 'forge'],
            ['name' => 'Envoyer', 'slug' => 'envoyer'],
            ['name' => 'Homestead', 'slug' => 'homestead'],
            ['name' => 'Valet', 'slug' => 'valet'],
            ['name' => 'Socialite', 'slug' => 'socialite'],
            ['name' => 'Mix', 'slug' => 'mix'],
            ['name' => 'Dusk', 'slug' => 'dusk'],
            ['name' => 'Jetstream', 'slug' => 'jetstream'],
            ['name' => 'Fortify', 'slug' => 'fortify'],
            ['name' => 'Sail', 'slug' => 'sail'],
            ['name' => 'Envoy', 'slug' => 'envoy'],
            ['name' => 'Vapor', 'slug' => 'vapor'],
            ['name' => 'Cashier', 'slug' => 'cashier'],
            ['name' => 'Breeze', 'slug' => 'breeze'],
            ['name' => 'Echo', 'slug' => 'echo'],
            ['name' => 'Horizon', 'slug' => 'horizon'],
            ['name' => 'Sanctum', 'slug' => 'sanctum'],
            ['name' => 'Scout', 'slug' => 'scout'],
            ['name' => 'Tinker', 'slug' => 'tinker'],
            ['name' => 'Routing', 'slug' => 'routing'],
            ['name' => 'Middleware', 'slug' => 'middleware'],
            ['name' => 'Logging', 'slug' => 'logging'],
            ['name' => 'Artisan', 'slug' => 'artisan'],
            ['name' => 'Notifications', 'slug' => 'notifications'],
            ['name' => 'Scheduling', 'slug' => 'scheduling'],
            ['name' => 'Authorization', 'slug' => 'authorization'],
            ['name' => 'Encryption', 'slug' => 'encryption'],
            ['name' => 'Passport', 'slug' => 'passport'],
            ['name' => 'Nova', 'slug' => 'nova'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Vue.js', 'slug' => 'vuejs'],
            ['name' => 'Alpine.js', 'slug' => 'alpinejs'],
            ['name' => 'API', 'slug' => 'api'],
            ['name' => 'Octane', 'slug' => 'octane'],
        ]);

        $tagIds = array_flip(Tag::all()->pluck('id')->toArray());
        $articles = Article::all();
        $threads = Thread::all();
        $taggables = [];

        foreach ($articles as $article) {
            foreach (array_rand($tagIds, 3) as $tagId) {
                $taggables[] = [
                    'taggable_id' => $article->id,
                    'taggable_type' => 'articles',
                    'tag_id' => $tagId,
                ];
            }
        }

        foreach ($threads as $thread) {
            foreach (array_rand($tagIds, 3) as $tagId) {
                $taggables[] = [
                    'taggable_id' => $thread->id,
                    'taggable_type' => 'threads',
                    'tag_id' => $tagId,
                ];
            }
        }

        DB::table('taggables')->insert($taggables);
    }
}
