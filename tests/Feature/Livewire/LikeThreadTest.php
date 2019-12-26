<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\LikeThread;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LikeThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_toggle_a_like_on_a_thread()
    {
        $this->login();
        $thread = factory(Thread::class)->create();

        Livewire::test(LikeThread::class, $thread)
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("1\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function a_logged_out_user_cannot_toggle_a_like_on_a_thread()
    {
        $thread = factory(Thread::class)->create();

        Livewire::test(LikeThread::class, $thread)
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }
}
