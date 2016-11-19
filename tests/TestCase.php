<?php

namespace Tests;

use App\Helpers\BuildsModels;
use App\Users\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Hash;

abstract class TestCase extends IlluminateTestCase
{
    use BuildsModels, HttpAssertions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Thanks for the tip Jeff!
        Hash::setRounds(5);

        return $app;
    }

    protected function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    protected function createUser(array $attributes = []): User
    {
        return $this->create(User::class, array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'github_url' => 'johndoe',
        ], $attributes));
    }
}
