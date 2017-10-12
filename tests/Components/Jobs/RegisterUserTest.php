<?php

namespace Tests\Components\Jobs;

use App\Exceptions\CannotCreateUser;
use App\Jobs\RegisterUser;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_user()
    {
        $job = new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe');

        $this->assertInstanceOf(User::class, $job->handle($this->app->make(Hasher::class)));
    }

    /** @test */
    public function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->expectException(CannotCreateUser::class);

        $job = new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe');
        $job->handle($this->app->make(Hasher::class));

        $job = new RegisterUser('John Doe', 'john@example.com', 'john', '', 'password', '123', 'johndoe');
        $job->handle($this->app->make(Hasher::class));
    }

    /** @test */
    public function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        $job = new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe');
        $job->handle($this->app->make(Hasher::class));

        $job = new RegisterUser('John Doe', 'doe@example.com', 'johndoe', '', 'password', '123', 'johndoe');
        $job->handle($this->app->make(Hasher::class));
    }
}
