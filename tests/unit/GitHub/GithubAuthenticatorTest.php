<?php
namespace Lio\Tests\Unit\Github;

use Lio\Github\GithubAuthenticator;
use Lio\Tests\TestCase;
use Mockery as m;

class GithubAuthenticatorTest extends TestCase
{
    public function testCanCreateGithubAuthenticator()
    {
        $this->assertInstanceOf('Lio\Github\GithubAuthenticator', $this->getAuthenticator());
    }

    public function testExistingUserCanBeFound()
    {
        // remove the reader from the test
        $reader = m::mock('Lio\Github\GithubUserDataReader');
        $reader->shouldReceive('getDataFromCode')->andReturn(['id' => 1]);

        // create a fake user for the user repository to return
        // (hint: it wasn't banned)
        $user = m::mock()->shouldIgnoreMissing();
        $user->is_banned = 0;

        // create a fake user repository, when it's queried for
        // a user by Github id, give the user that we just made
        $users = m::mock('Lio\Accounts\UserRepository')->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn($user);

        // create an instance of the authenticator, passing in
        // the user repository and the reader
        $auth = $this->getAuthenticator($users, $reader);

        // create a fake listener
        $observer = m::mock('Lio\Github\GithubAuthenticatorListener');
        $observer->shouldReceive('userFound')->once();

        // Our goal here is to ensure that when a non-banned user
        // is found by its Github id, the observer's userFound()
        // method is called
        $auth->authByCode($observer, 'foo');
    }

    public function testBannedUsersCantAuthenticate()
    {
        $reader = m::mock('Lio\Github\GithubUserDataReader');
        $reader->shouldReceive('getDataFromCode')->andReturn(['id' => 1]);

        $user = m::mock()->shouldIgnoreMissing();
        $user->is_banned = 1;

        $users = m::mock('Lio\Accounts\UserRepository')->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn($user);

        $auth = $this->getAuthenticator($users, $reader);

        $observer = m::mock('Lio\Github\GithubAuthenticatorListener');
        $observer->shouldReceive('userIsBanned')->once();

        // when a banned user is found by its Github id, the
        // observer's userIsBand() method is called
        $auth->authByCode($observer, 'foo');
    }

    public function testUnfoundUserTriggersObserverCorrectly()
    {
        $reader = m::mock('Lio\Github\GithubUserDataReader');
        $reader->shouldReceive('getDataFromCode')->andReturn(['id' => 1]);

        // create a fake user repository, when it's queried for
        // a user by Github id, give it nothing
        $users = m::mock('Lio\Accounts\UserRepository')->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn(null);

        $auth = $this->getAuthenticator($users, $reader);

        $observer = m::mock('Lio\Github\GithubAuthenticatorListener');
        $observer->shouldReceive('userNotFound')->once();

        $auth->authByCode($observer, 'foo');
    }

    private function getAuthenticator($userRepository = null, $reader = null)
    {
        $userRepository = $userRepository ?: m::mock('Lio\Accounts\UserRepository');
        $reader = $reader ?: m::mock('Lio\Github\GithubUserDataReader');

        return new GithubAuthenticator($userRepository, $reader);
    }
}
