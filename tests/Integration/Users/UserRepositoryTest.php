<?php
namespace Lio\Tests\Integration\Users;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Lio\Testing\RepositoryTest;
use Lio\Tests\TestCase;
use Lio\Users\User;
use Lio\Users\UserRepository;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations, RepositoryTest;

    protected $repoName = UserRepository::class;

    /** @test */
    public function find_by_username()
    {
        $this->createUser();

        $this->assertInstanceOf(User::class, $this->repo->findByUsername('johndoe'));
    }
}
