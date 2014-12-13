<?php
namespace Lio\Validators;

class DoesNotContainPhoneNumbers
{
    /**
     * Determines if the value contains phone numbers
     *
     * @param string $value
     * @return bool
     */
    public function validate($value)
    {
        return ! (bool) preg_match('/\+(?:\d{1,2})?[\s-+]*?(?:\d{10,})/', $value);
    }
}
