<?php namespace Lio\GitHub;
use Codeception\Util\Stub;
use Mockery;

class GithubAccountIntegratorTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before() {}
    protected function _after() {}

    // tests
    public function testCanCreate()
    {
        $this->assertInstanceOf('Lio\GitHub\GithubAccountIntegrator', $this->getIntegrator());
    }



    //-------- private ---------//
    private function getIntegrator()
    {
        return new GithubAccountIntegrator;
    }
}