<?php namespace Lio\Github;
use Codeception\Util\Stub;
use Mockery as m;

class GithubAuthenticatorTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before() {}
    protected function _after() {}

    // tests
    public function testCanCreateGithubAuthenticator()
    {
        $this->assertInstanceOf('Lio\Github\GithubAuthenticator', $this->getAuthenticator());
    }



    //-------- private ---------//
    private function getAuthenticator($userRepository = null, $reader = null)
    {
        $userRepository = $userRepository ?: m::mock('Lio\Accounts\UserRepository');
        $reader = $reader ?: m::mock('Lio\Github\GithubUserDataReader');

        return new GithubAuthenticator($userRepository, $reader);
    }
}