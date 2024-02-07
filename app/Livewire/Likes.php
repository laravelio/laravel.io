<?php

namespace App\Livewire;

use Livewire\Component;

final class Likes extends Component
{
    public $isSidebar = true;

    public $subject;

    public $type;

    private $limit = 10;

    public $likers = '';

    public function mount($subject): void
    {
        $this->subject = $subject;

        $likers = $this->getLikers();

        $this->likers = collect($this->getLikers())
            ->slice(0, $this->limit)
            ->implode(', ');

        if (count($likers) > $this->limit) {
            $this->likers .= ' and more';
        }
    }

    public function getLikers(): array
    {
        $likers = $this->subject->likersRelation()->limit($this->limit + 1)->pluck('username')->toArray();

        if (auth()->check() && in_array($authUsername = auth()->user()->username, $likers)) {
            $likers = array_diff($likers, [$authUsername]);
            array_unshift($likers, 'you');
        }

        return $likers;
    }
}
