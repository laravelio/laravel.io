<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Edit;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Edit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $editableClass = $this->faker->randomElement([Article::class, Reply::class, Thread::class]);
        $editableFactory = call_user_func([$editableClass, 'factory']);

        return [
            'author_id' => function () {
                return User::factory()->create()->id;
            },
            'editable_id' => function () use ($editableFactory) {
                return $editableFactory->create()->id;
            },
            'editable_type' => function () use ($editableClass) {
                return constant($editableClass.'::TABLE') ?? $editableClass;
            },
            'edited_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
