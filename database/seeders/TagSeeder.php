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
            $this->createTag('Configuration', 'configuration'),
            $this->createTag('Authentication', 'authentication'),
            $this->createTag('Security', 'security'),
            $this->createTag('Requests', 'requests'),
            $this->createTag('Input', 'input'),
            $this->createTag('Session', 'session'),
            $this->createTag('Cache', 'cache'),
            $this->createTag('Database', 'database'),
            $this->createTag('Eloquent', 'eloquent'),
            $this->createTag('IOC', 'ioc'),
            $this->createTag('Views', 'views'),
            $this->createTag('Blade', 'blade'),
            $this->createTag('Forms', 'forms'),
            $this->createTag('Validation', 'validation'),
            $this->createTag('Mail', 'mail'),
            $this->createTag('Queues', 'queues'),
            $this->createTag('Laravel.io', 'laravelio'),
            $this->createTag('Packages', 'packages'),
            $this->createTag('Meetups', 'meetups'),
            $this->createTag('Architecture', 'architecture'),
            $this->createTag('Jobs', 'jobs'),
            $this->createTag('Testing', 'testing'),
            $this->createTag('Laravel', 'laravel'),
            $this->createTag('Lumen', 'lumen'),
            $this->createTag('Spark', 'spark'),
            $this->createTag('Forge', 'forge'),
            $this->createTag('Envoyer', 'envoyer'),
            $this->createTag('Homestead', 'homestead'),
            $this->createTag('Valet', 'valet'),
            $this->createTag('Socialite', 'socialite'),
            $this->createTag('Mix', 'mix'),
            $this->createTag('Dusk', 'dusk'),
            $this->createTag('Jetstream', 'jetstream'),
            $this->createTag('Fortify', 'fortify'),
            $this->createTag('Sail', 'sail'),
            $this->createTag('Envoy', 'envoy'),
            $this->createTag('Vapor', 'vapor'),
            $this->createTag('Cashier', 'cashier'),
            $this->createTag('Breeze', 'breeze'),
            $this->createTag('Echo', 'echo'),
            $this->createTag('Horizon', 'horizon'),
            $this->createTag('Sanctum', 'sanctum'),
            $this->createTag('Scout', 'scout'),
            $this->createTag('Tinker', 'tinker'),
            $this->createTag('Routing', 'routing'),
            $this->createTag('Middleware', 'middleware'),
            $this->createTag('Logging', 'logging'),
            $this->createTag('Artisan', 'artisan'),
            $this->createTag('Notifications', 'notifications'),
            $this->createTag('Scheduling', 'scheduling'),
            $this->createTag('Authorization', 'authorization'),
            $this->createTag('Encryption', 'encryption'),
            $this->createTag('Passport', 'passport'),
            $this->createTag('Nova', 'nova'),
            $this->createTag('JavaScript', 'javascript'),
            $this->createTag('Vue.js', 'vuejs'),
            $this->createTag('Alpine.js', 'alpinejs'),
            $this->createTag('API', 'api'),
            $this->createTag('Octane', 'octane'),
        ]);

        Article::all()->each(function ($article) use ($tags) {
            $article->syncTags(
                $tags->random(rand(0, $tags->count()))
                    ->take(3)
                    ->pluck('id')
                    ->toArray(),
            );
        });

        Thread::all()->each(function ($article) use ($tags) {
            $article->syncTags(
                $tags->random(rand(0, $tags->count()))
                    ->take(3)
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
