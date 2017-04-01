<?php

namespace Tests\Components;

use App\Exceptions\CannotCreateUser;
use App\Http\Requests\RegisterRequest;
use App\Jobs\RegisterUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function find_by_username()
    {
        $this->createUser(['username' => 'johndoe']);

        $this->assertInstanceOf(User::class, User::findByUsername('johndoe'));
    }

    /** @test */
    function find_by_email_address()
    {
        $this->createUser(['email' => 'john@example.com']);

        $this->assertInstanceOf(User::class, User::findByEmailAddress('john@example.com'));
    }

    /** @test */
    function we_can_create_a_user()
    {
        $this->assertInstanceOf(User::class, (new RegisterUser($this->newRegistration(
            'john@example.com',
            'johndoe'
        )))->handle());
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->expectException(CannotCreateUser::class);

        (new RegisterUser($this->newRegistration('john@example.com', 'johndoe')))->handle();
        (new RegisterUser($this->newRegistration('john@example.com', 'johnfoo')))->handle();
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        (new RegisterUser($this->newRegistration('john@example.com', 'johndoe')))->handle();
        (new RegisterUser($this->newRegistration('john.doe@example.com', 'johndoe')))->handle();
    }

    private function newRegistration($emailAddress, $username)
    {
        return new class($emailAddress, $username) extends RegisterRequest
        {
            public function __construct($emailAddress, $username)
            {
                $this->emailAddress = $emailAddress;
                $this->username = $username;
            }

            public function name(): string
            {
                return 'John Doe';
            }

            public function emailAddress(): string
            {
                return $this->emailAddress;
            }

            public function username(): string
            {
                return $this->username;
            }

            public function password(): string
            {
                return 'password';
            }

            public function ip()
            {
                return '';
            }

            public function githubId(): string
            {
                return '';
            }

            public function githubUsername(): string
            {
                return '';
            }
        };
    }
}
