<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\LikeReply;
use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LikeReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_toggle_a_like_on_a_reply()
    {
        $this->login();
        $reply = factory(Reply::class)->create();

        Livewire::test(LikeReply::class, $reply)
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("1\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }

    /** @test */
    public function a_logged_out_user_cannot_toggle_a_like_on_a_reply()
    {
        $reply = factory(Reply::class)->create();

        Livewire::test(LikeReply::class, $reply)
            ->assertSee("0\n")
            ->call('toggleLike')
            ->assertSee("0\n");
    }
}
