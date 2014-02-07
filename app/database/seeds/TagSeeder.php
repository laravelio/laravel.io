<?php

use Lio\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        if (Tag::count() == 0) {
            $this->createTags();
        }
    }

    private function createTags()
    {
        $commonTags = [
            'Installation' => 'framework installation, package installation, application installation',
            'Configuration' => 'framework configuration, web-server configuration, application configuration',
            'Authentication' => 'topics related to authentication, including user logins, oauth, etc',
            'Security' => 'code safety, user roles and authorization',
            'Requests' => 'information related to handling requests',
            'Input' => 'handling user input',
            'Session' => 'persisting data between requests using PHP or Laravel sessions',
            'Cache' => 'performance caching or any use of Laravel\'s cache system',
            'Database' => 'query-building, connections, or drivers',
            'Eloquent' => 'Eloquent modeling, relationships, etc',
            'Ioc' => 'binding to and resolving from the IoC container',
            'Views' => 'topics related to the rendering of views',
            'Blade' => 'topics related to Blade templating',
            'Forms' => 'topics related to forms',
            'Validation' => 'topics related to the validation of data',
            'Mail' => 'topics related to compiling and sending email',
            'Queues' => 'topics related to queues',
            'LaravelIO' => 'topics that relate to the Laravel.io site or community',
            'Packages' => 'topics related to creating, discussing, and importing packages',
            'Meetups' => 'topics related to community meetups or user groups',
            'OOP' => 'topics related to writing good object-oriented code',
            'Testing' => 'topics related to automated testing',
        ];

        foreach ($commonTags as $name => $description) {
            Tag::create([
                'name' => $name,
                'slug' => $name,
                'description' => $description,
                'articles' => 1,
                'forum' => 1,
            ]);
        }

        $articleTags = [
            'News' => 'information about an occurance',
        ];

        foreach ($articleTags as $name => $description) {
            Tag::create([
                'name' => $name,
                'slug' => $name,
                'description' => $description,
                'articles' => 1,
                'forum' => 0,
            ]);
        }
    }
}
