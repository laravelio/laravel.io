<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ListBlockedUsers extends Component
{
    public $userId;
    public $blockedUsername = '';

    public function mount($user)
    {
        $this->userId = $user->getKey();
    }

    public function getBlockedUsersProperty()
    {
        return User::find($this->userId)->blockedUsers;
    }

    public function getPotentiallyBlockedUsersProperty()
    {
        return User::query()
            ->whereKeyNot($this->userId)
            ->whereRaw('username like ? escape ?', ["%{$this->blockedUsername}%", '\\'])
            ->whereNotIn('id', User::find($this->userId)->blockedUsers->pluck('id'))
            ->get();
    }

    public function addBlockedUser()
    {
        $this->validate([
            'blockedUsername' => [
                'required',
                Rule::exists('users', 'username')
                    ->whereNotIn('id', [$this->userId]),
            ],
        ]);

        $user = User::query()->where('username', $this->blockedUsername)->first();
        User::find($this->userId)->blockedUsers()->attach($user->getKey());

        $this->reset('blockedUsername');
    }

    public function removeBlockedUser($username)
    {
        $blockedUser = User::findByUsername($username);
        User::find($this->userId)->blockedUsers()->detach($blockedUser->getKey());

        $this->reset('blockedUsername');
    }
}
