<?php

namespace App\Livewire;

use App\Jobs\LikeArticle as LikeArticleJob;
use App\Jobs\UnlikeArticle as UnlikeArticleJob;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class LikeArticle extends Component
{
    public $article;

    public $isSidebar = true;

    public $showLikers = false;

    private $likersLimit = 10;

    public $likers = '';

    protected $listeners = ['likeToggled', 'toggleLikers'];

    public function mount(Article $article): void
    {
        $this->article = $article;

        $likers = $this->getLikers();
        $this->likers = implode(', ', $likers);

        if (count($likers) > $this->likersLimit) {
            $this->likers .= ' and more';
        }
    }

    public function toggleLike(): void
    {
        if (Auth::guest()) {
            return;
        }

        if ($this->article->isLikedBy(Auth::user())) {
            dispatch_sync(new UnlikeArticleJob($this->article, Auth::user()));
        } else {
            dispatch_sync(new LikeArticleJob($this->article, Auth::user()));
        }

        $this->dispatch('likeToggled');
    }

    public function likeToggled()
    {
        return $this->article;
    }

    public function toggleLikers(): void
    {
        if (strlen($this->likers)) {
            $this->showLikers = ! $this->showLikers;
        }
    }

    public function getLikers(): array
    {
        return $this->article->likers()->pluck('username')->toArray();
    }
}
