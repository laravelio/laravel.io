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
            [
                'title'         => 'Laravel 4.x Help',
                'slug'          => 'laravel4-help',
                'description'   => 'This forum is the place to find community support for Laravel 4.x.',
                'show_in_index' => 1,
            ], [
                'title'         => 'Laravel 3.x Help',
                'slug'          => 'laravel3-help',
                'description'   => 'This forum is the place to find community support for Laravel 3.x.',
                'show_in_index' => 1,
            ]
        ];

        foreach ($categories as $category) {
            ForumCategory::create($category);
        }
    }
}