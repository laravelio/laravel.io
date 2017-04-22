<?php

namespace Tests\Components\Models;

use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_retrieve_paginated_results_in_a_correct_order()
    {
        $threadUpdatedYesterday = $this->createThreadFromYesterday();
        $threadFromToday = $this->createThreadFromToday();
        $threadFromTwoDaysAgo = $this->createThreadFromTwoDaysAgo();

        $threads = Thread::findForForum();

        $this->assertTrue($threadFromToday->matches($threads->first()), 'First thread is incorrect');
        $this->assertTrue($threadUpdatedYesterday->matches($threads->slice(1)->first()), 'Second thread is incorrect');
        $this->assertTrue($threadFromTwoDaysAgo->matches($threads->last()), 'Last thread is incorrect');
    }

    private function createThreadFromToday(): Thread
    {
        $today = Carbon::now();

        return factory(Thread::class)->create(['created_at' => $today]);
    }

    private function createThreadFromYesterday(): Thread
    {
        $yesterday = Carbon::yesterday();

        return factory(Thread::class)->create(['created_at' => $yesterday]);
    }

    private function createThreadFromTwoDaysAgo(): Thread
    {
        $twoDaysAgo = Carbon::now()->subDay(2);

        return factory(Thread::class)->create(['created_at' => $twoDaysAgo]);
    }
}
