<?php

namespace Tests\Feature;

use Tests\TestCase;

class PastebinRedirectTest extends TestCase
{
    /** @test */
    public function it_redirects_to_the_paste_bin_website_when_accessing_the_old_url()
    {
        $this->get('/bin')
            ->assertRedirect('https://paste.laravel.io/');
    }

    /** @test */
    public function it_redirects_to_the_paste_bin_website_when_accessing_a_hash()
    {
        $this->get('/bin/some-hash')
            ->assertRedirect('https://paste.laravel.io/some-hash');
    }
}
