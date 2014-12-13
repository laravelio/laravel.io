<?php
namespace Lio\Tests\Unit\Validators;

use Lio\Validators\DoesNotContainPhoneNumbers;

class DoesNotContainPhoneNumbersTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_can_detect_phone_numbers_in_a_string()
    {
        $validator = new DoesNotContainPhoneNumbers();

        $this->assertFalse($validator->validate(file_get_contents(__DIR__ . '/phone_numbers.txt')));
    }

    /** @test */
    function it_passes_when_no_phone_numbers_are_detected()
    {
        $validator = new DoesNotContainPhoneNumbers();

        $this->assertTrue($validator->validate(file_get_contents(__DIR__ . '/no_phone_numbers.txt')));
    }
}
