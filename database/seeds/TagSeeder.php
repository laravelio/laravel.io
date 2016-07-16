<?php

use Illuminate\Database\Seeder;
use Lio\ModelFactories\BuildsModels;
use Lio\Tags\Tag;

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
