<?php
namespace Lio\Tests\Integration\Users;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;
use Lio\Users\Exceptions\UserCreationException;
use Lio\Users\User;
use Lio\Users\UserRepository;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = UserRepository::class;

    /** @test */
    function find_by_username()
    {
        $this->createUser();

        $this->assertInstanceOf(User::class, $this->repo->findByUsername('johndoe'));
    }

    /** @test */
    function find_by_email_address()
    {
        $this->createUser();

        $this->assertInstanceOf(User::class, $this->repo->findByEmailAddress('john@example.com'));
    }

    /** @test */
    function we_can_create_a_user()
    {
        $this->assertInstanceOf(User::class, $this->repo->create(
            'John Doe',
            'john@example.com',
            'password',
            'johndoe'
        ));
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->setExpectedException(
            UserCreationException::class,
            'The email address [john@example.com] already exists.'
        );

        $this->repo->create('John Doe', 'john@example.com', 'password', 'johndoe');
        $this->repo->create('John Foo', 'john@example.com', 'password', 'johnfoo');
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_username()
    {
        $this->setExpectedException(
            UserCreationException::class,
            'The username [johndoe] already exists.'
        );

        $this->repo->create('John Doe', 'john@example.com', 'password', 'johndoe');
        $this->repo->create('John Doe', 'john.doe@example.com', 'password', 'johndoe');
    }
}
