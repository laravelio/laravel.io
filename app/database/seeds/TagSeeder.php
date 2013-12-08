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
            'installation'   => 'framework installation, package installation, application installation',
            'configuration'  => 'framework configuration, web-server configuration, application configuration',
            'authentication' => 'authentication including: user logins, oauth, etc',
            'security'       => 'code safety, user roles and authorization',
            'requests'       => 'information related to handling requests',
            'input'          => 'handling user input',
            'session'        => 'persisting data between requests using PHP or Laravel sessions',
            'cache'          => 'performance caching or any use of Laravel\'s cache system',
            'database'       => 'query-building, connections, or drivers',
            'eloquent'       => 'Eloquent modeling, relationships, etc',
            'ioc'            => 'binding to and resolving from the IoC container',
            'views'          => 'topics relating to the rendering of views',
            'blade'          => 'topics related to Blade templating',
            'forms'          => 'topics related to forms',
            'validation'     => 'topics related to the validation of data',
            'mail'           => 'topics related to compiling and sending email',
            'queues'         => 'topics related to queues',
            'laravelio'      => 'topics that relate to the Laravel.io site or community',
            'Packages'       => 'topics related to creating, discussing, and importing packages',
            'Meetups'        => 'topics related to community meetups or user groups',
        ];

        foreach ($commonTags as $name => $description) {
            Tag::create([
                'name'        => $name,
                'slug'        => $name,
                'description' => $description,
                'articles'    => 1,
                'forum'       => 1,
            ]);
        }

        $articleTags = [
            'news' => 'appropriate for articles that are about an occurance',
        ];

        foreach ($articleTags as $name => $description) {
            Tag::create([
                'name'        => $name,
                'slug'        => $name,
                'description' => $description,
                'articles'    => 1,
                'forum'       => 0,
            ]);
        }
    }
}