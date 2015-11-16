<?php
namespace Lio\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;
use Lio\Testing\BuildsModels;
use Lio\Users\User;

abstract class TestCase extends IlluminateTestCase
{
    use BuildsModels;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param array $attributes
     * @return \Lio\Users\User
     */
    protected function login(array $attributes = [])
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    /**
     * @param array $attributes
     * @return \Lio\Users\User
     */
    protected function createUser(array $attributes = [])
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
