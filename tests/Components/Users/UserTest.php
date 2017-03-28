<?php

namespace Tests\Components\Users;

use App\Users\Exceptions\CannotCreateUser;
use App\Users\UserData;
use App\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
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
        $this->assertInstanceOf(User::class, User::createFromData($this->userData(
            'john@example.com',
            'johndoe'
        )));
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->expectException(CannotCreateUser::class);

        User::createFromData($this->userData('john@example.com', 'johndoe'));
        User::createFromData($this->userData('john@example.com', 'johnfoo'));
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        User::createFromData($this->userData('john@example.com', 'johndoe'));
        User::createFromData($this->userData('john.doe@example.com', 'johndoe'));
    }

    private function userData($emailAddress, $username)
    {
        return new class($emailAddress, $username) implements UserData
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
