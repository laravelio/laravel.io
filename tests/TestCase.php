<?php

namespace Tests;

use App\Ai\Agents\ArticleReviewer;
use App\Ai\Agents\SpamModerator;
use Illuminate\Foundation\Testing\TestCase as IlluminateTestCase;

class TestCase extends IlluminateTestCase
{
    use CreatesUsers;
    use HttpAssertions;

    protected function setUp(): void
    {
        parent::setUp();

        SpamModerator::fake(fn () => ['is_spam' => false])->preventStrayPrompts();
        ArticleReviewer::fake(fn () => ['is_suitable' => true])->preventStrayPrompts();
    }

    protected function dispatch($job): void
    {
        $job->handle();
    }
}
