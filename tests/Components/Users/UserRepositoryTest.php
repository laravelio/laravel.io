<?php

namespace Tests\Components\Users;

use App\Users\Exceptions\CannotCreateUser;
use App\Users\NewUser;
use App\Users\User;
use App\Users\UserRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\TestsRepository;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations, TestsRepository;

    /**
     * @var \App\Users\UserRepository
     */
    protected $repo = UserRepository::class;

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
        $this->assertInstanceOf(User::class, $this->repo->create(new DummyNewUser(
            'John Doe',
            'john@example.com',
            'johndoe',
            'password'
        )));
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->expectException(CannotCreateUser::class);

        $this->repo->create(new DummyNewUser('John Doe', 'john@example.com', 'johndoe', 'password'));
        $this->repo->create(new DummyNewUser('John Foo', 'john@example.com', 'johnfoo', 'password'));
    }

    /** @test */
    function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        $this->repo->create(new DummyNewUser('John Doe', 'john@example.com', 'johndoe', 'password'));
        $this->repo->create(new DummyNewUser('John Doe', 'john.doe@example.com', 'johndoe', 'password'));
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

class DummyNewUser implements NewUser
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    public function __construct($name, $emailAddress, $username, $password = null)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
        $this->username = $username;
        $this->password = $password;
    }

    public function name(): string
    {
        return $this->name;
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
        return $this->password ?: '';
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
}
