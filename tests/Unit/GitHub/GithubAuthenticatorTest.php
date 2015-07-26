<?php
namespace Lio\Tests\Unit\Github;

use Laravel\Socialite\Contracts\Provider as SocialiteProvider;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Lio\Accounts\User;
use Lio\Accounts\UserRepository;
use Lio\Github\GithubAuthenticator;
use Lio\Github\GithubAuthenticatorListener;
use Mockery as m;

class GithubAuthenticatorTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testCanCreateGithubAuthenticator()
    {
        $this->assertInstanceOf(GithubAuthenticator::class, $this->getAuthenticator());
    }

    public function testExistingUserCanBeFound()
    {
        $socialiteUser = $this->mockSocialiteUser();
        $socialiteUser->shouldReceive('getId')->andReturn(1);

        $socialite = $this->mockSocialiteProvider();
        $socialite->shouldReceive('user')->andReturn($socialiteUser);

        // create a fake user for the user repository to return
        // (hint: it wasn't banned)
        $user = m::mock(User::class);
        $user->shouldReceive('isBanned')->andReturn(false);

        // create a fake user repository, when it's queried for
        // a user by Github id, give the user that we just made
        $users = $this->mockUsersRepository()->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn($user);

        // create an instance of the authenticator, passing in
        // the user repository and the reader
        $auth = $this->getAuthenticator($socialite, $users);

        // create a fake listener
        $listener = $this->mockListener();
        $listener->shouldReceive('userFound')->once();

        // Our goal here is to ensure that when a non-banned user
        // is found by its Github id, the observer's userFound()
        // method is called
        $auth->authBySocialite($listener);
    }

    public function testBannedUsersCantAuthenticate()
    {
        $socialiteUser = $this->mockSocialiteUser();
        $socialiteUser->shouldReceive('getId')->andReturn(1);

        $socialite = $this->mockSocialiteProvider();
        $socialite->shouldReceive('user')->andReturn($socialiteUser);

        $user = m::mock(User::class);
        $user->shouldReceive('isBanned')->andReturn(true);

        $users = $this->mockUsersRepository()->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn($user);

        $auth = $this->getAuthenticator($socialite, $users);

        $listener = $this->mockListener();
        $listener->shouldReceive('userIsBanned')->once();

        // when a banned user is found by its Github id, the
        // listener's userIsBand() method is called
        $auth->authBySocialite($listener);
    }

    public function testUnfoundUserTriggersObserverCorrectly()
    {
        $socialiteUser = $this->mockSocialiteUser()->shouldIgnoreMissing();
        $socialiteUser->shouldReceive('getId')->andReturn(1);

        $socialite = $this->mockSocialiteProvider();
        $socialite->shouldReceive('user')->andReturn($socialiteUser);

        // create a fake user repository, when it's queried for
        // a user by Github id, give it nothing
        $users = $this->mockUsersRepository()->shouldIgnoreMissing();
        $users->shouldReceive('getByGithubId')->andReturn(null);

        $auth = $this->getAuthenticator($socialite, $users);

        $listener = $this->mockListener();
        $listener->shouldReceive('userNotFound')->once();

        $auth->authBySocialite($listener);
    }

    /**
     * @param \Mockery\MockInterface $socialite
     * @param \Mockery\MockInterface $users
     * @return \Lio\Github\GithubAuthenticator
     */
    private function getAuthenticator($socialite = null, $users = null)
    {
        $socialite = $socialite ?: $this->mockSocialiteProvider();
        $users = $users ?: $this->mockUsersRepository();

        return new GithubAuthenticator($socialite, $users);
    }

    private function mockSocialiteProvider()
    {
        return m::mock(SocialiteProvider::class);
    }

    private function mockSocialiteUser()
    {
        return m::mock(SocialiteUser::class);
    }

    /**
     * @return \Mockery\MockInterface
     */
    private function mockUsersRepository()
    {
        return m::mock(UserRepository::class);
    }

    /**
     * @return \Mockery\MockInterface
     */
    private function mockListener()
    {
        return m::mock(GithubAuthenticatorListener::class);
    }
}
