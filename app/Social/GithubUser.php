<?php

namespace App\Social;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final class GithubUser implements Arrayable
{
    public function __construct(
        private array $attributes
    ) {
    }

    public function isTooYoung(): bool
    {
        return $this->createdAt() > $this->twoWeeksAgo();
    }

    public function createdAt(): Carbon
    {
        return new Carbon($this->get('created_at'));
    }

    private function twoWeeksAgo(): Carbon
    {
        return Carbon::now()->subDays(14);
    }

    private function get(string $name)
    {
        return Arr::get($this->attributes, $name);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->get('id'),
            'name' => $this->get('name'),
            'email' => $this->get('email'),
            'username' => $this->get('login'),
        ];
    }
}
