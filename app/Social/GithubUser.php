<?php

namespace App\Social;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class GithubUser implements Arrayable
{
    /**
     * @var array
     */
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function isYoungerThanTwoWeeks(): bool
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

    private function get($name)
    {
        return Arr::get($this->attributes, $name);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->attributes['id'],
            'name' => $this->attributes['name'],
            'email' => $this->attributes['email'],
            'username' => $this->attributes['login'],
        ];
    }
}
