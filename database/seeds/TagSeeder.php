<?php

use App\ModelFactories\BuildsModels;
use App\Tags\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    use BuildsModels;

    public function run()
    {
        $this->createTag('Installation', 'installation');
        $this->createTag('Blade', 'blade');
        $this->createTag('Cache', 'cache');
    }

    private function createTag($name, $slug)
    {
        $this->create(Tag::class, compact('name', 'slug'));
    }
}
