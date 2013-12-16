<?php

use Mockery as m;

class UnitTestCase extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before() {}
    protected function _after()
    {
        m::close();
    }
}