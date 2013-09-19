<?php

use Lio\Forum\ForumCategory;

class ForumCategorySeeder extends Seeder
{
    public function run()
    {
        if (ForumCategory::count() == 0) {
            $this->createForumCategories();
        }
    }

    private function createForumCategories()
    {
        $categories = [
            'Laravel 4.x Help' => 'This forum is the place to find community support for Laravel 4.x.',
            'Laravel 3.x Help' => 'This forum is the place to find community support for Laravel 3.x.',
        ];

        foreach ($categories as $title => $description) {
            ForumCategory::create(compact('title', 'description'));
        }
    }
}