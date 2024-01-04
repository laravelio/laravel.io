<?php

namespace App\Livewire;

use Livewire\Component;

final class Like extends Component
{
    public $isSidebar = true;

    public $likable;

    public $showLikers = false;

    private $likersLimit = 10;

    public $likers = '';

    protected $listeners = ['toggleLikers'];

    public function mount($likable): void
    {
        $this->likable = $likable;

        $likers = $this->getLikers();
        $this->likers = implode(', ', array_slice($likers, 0, $this->likersLimit));

        if (count($likers) > $this->likersLimit) {
            $this->likers .= ' and more';
        }
    }

    public function toggleLikers(): void
    {
        if (strlen($this->likers)) {
            $this->showLikers = ! $this->showLikers;
        }
    }

    public function getLikers(): array
    {
        return $this->likable->likers()->pluck('username')->toArray();
    }
}
