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

    protected $listeners = ['likeToggled'];

    public function mount(Article $article): void
    {
        $this->article = $article;
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
}
