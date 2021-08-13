<?php

namespace App\Http\Livewire;

use App\Jobs\LikeArticle as LikeArticleJob;
use App\Jobs\UnlikeArticle as UnlikeArticleJob;
use App\Models\Article;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class LikeArticle extends Component
{
    use DispatchesJobs;

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
            $this->dispatchNow(new UnlikeArticleJob($this->article, Auth::user()));
        } else {
            $this->dispatchNow(new LikeArticleJob($this->article, Auth::user()));
        }

        $this->emit('likeToggled');
    }

    public function likeToggled()
    {
        return $this->article;
    }
}
