<?php

namespace Tests\Integration\Users;

use App\Users\Exceptions\CannotCreateUser;
use App\Users\User;
use App\Users\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestsRepositories;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations, TestsRepositories;

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
        $this->expectException(CannotCreateUser::class);

        $this->repo->create('John Doe', 'john@example.com', 'password', 'johndoe');
        $this->repo->create('John Foo', 'john@example.com', 'password', 'johnfoo');
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        $this->repo->create('John Doe', 'john@example.com', 'password', 'johndoe');
        $this->repo->create('John Doe', 'john.doe@example.com', 'password', 'johndoe');
    }

    /** @test */
    function we_can_update_a_user()
    {
        $user = $this->createUser();

        $user = $this->repo->update($user, ['username' => 'foo', 'name' => 'bar']);

        $this->assertEquals('foo', $user->username());
        $this->seeInDatabase('users', ['username' => 'foo', 'name' => 'bar']);
    }
}
