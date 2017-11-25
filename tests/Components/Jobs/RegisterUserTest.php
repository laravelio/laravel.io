<?php

namespace Tests\Components\Jobs;

use Tests\TestCase;
use App\Jobs\RegisterUser;
use App\Exceptions\CannotCreateUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterUserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function we_can_create_a_user()
    {
        $user = $this->dispatch(
            new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe')
        );

        $this->assertEquals('John Doe', $user->name());
    }

    /** @test */
    public function we_cannot_create_a_user_with_the_same_email_address()
    {
        $this->expectException(CannotCreateUser::class);

        $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
        $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'john', '', 'password', '123', 'johndoe'));
    }

    /** @test */
    public function we_cannot_create_a_user_with_the_same_username()
    {
        $this->expectException(CannotCreateUser::class);

        $this->dispatch(new RegisterUser('John Doe', 'john@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
        $this->dispatch(new RegisterUser('John Doe', 'doe@example.com', 'johndoe', '', 'password', '123', 'johndoe'));
    }
}
