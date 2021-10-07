<?php

use Tests\TestCase;

uses(TestCase::class);

it('redirects to the paste bin website when accessing the old url', function () {
    $this->get('/bin')
        ->assertRedirect('https://paste.laravel.io/');
});

it('redirects to the paste bin website when accessing a hash', function () {
    $this->get('/bin/some-hash')
        ->assertRedirect('https://paste.laravel.io/some-hash');
});
