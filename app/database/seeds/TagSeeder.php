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
            'authentication' => 'any kind of authentication including: user logins, oauth, etc',
            'security'       => 'code safety, user roles and authorization',
            'requests'       => 'information related to handling requests',
            'input'          => 'handling user input',
            'session'        => 'persisting data between requests using PHP or Laravel sessions',
            'cache'          => 'performance caching or any use of Laravel\'s cache system',
            'database'       => 'query-building, connections, drivers',
            'eloquent'       => 'Eloquent modeling, relationships, etc',
            'architecture'   => 'related to the structure of an application',
            'ioc'            => 'binding to and resolving from the IoC container',
            'views'          => 'related to the rendering of views',
            'blade'          => 'related to Blade templating',
            'forms'          => 'all things related to forms',
            'validation'     => 'related to the validation of data',
            'mail'           => 'anything related to compiling and sending email',
            'queues'         => 'all things related to queues',
            'news'           => 'appropriate for articles that are about an occurance',
            'laravelio'      => 'directly relates to Laravel.io site and community',
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