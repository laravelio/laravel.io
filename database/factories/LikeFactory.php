<?php

namespace Database\Factories;

use App\Models\Like;
use App\Models\Reply;
use App\Models\Thread;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }

    public function reply()
    {
        return $this->state(function () {
            return [
                'likeable_id' => function () {
                    return Reply::factory()->create()->id;
                },
                'likeable_type' => 'replies',
            ];
        });
    }

    public function thread()
    {
        return $this->state(function () {
            return [
                'likeable_id' => function () {
                    return Thread::factory()->create()->id;
                },
                'likeable_type' => 'threads',
            ];
        });
    }
}
