<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Response;

trait HttpAssertions
{
    public function assertForbidden()
    {
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }
}
