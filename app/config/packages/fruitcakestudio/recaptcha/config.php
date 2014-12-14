<?php
/*
 |--------------------------------------------------------------------------
 | Laravel Configuration
 |--------------------------------------------------------------------------
 |
 | For usage with the Laravel Support Provider/Facade/Wrapper
 |
 */
return array(
    /*
     |--------------------------------------------------------------------------
     | Sitekey & Secret
     |--------------------------------------------------------------------------
     |
     | See https://www.google.com/recaptcha/admin
     |
     */
    'sitekey' => getenv('GOOGLE_RECAPTCHA_SITEKEY'),
    'secret'  => getenv('GOOGLE_RECAPTCHA_SECRETKEY'),

    /*
     |--------------------------------------------------------------------------
     | Default Language code
     |--------------------------------------------------------------------------
     |
     | See https://developers.google.com/recaptcha/docs/language
     |
     | When the value is null, the default App Locale will be used.
     |
     */
    'lang' => null,

);
