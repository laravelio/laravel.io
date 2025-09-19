<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Jobs\ApproveArticle;
use App\Jobs\DeclineArticle;
use App\Jobs\DisapproveArticle;
use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function approve(Article $article): RedirectResponse
    {
        $this->authorize(ArticlePolicy::APPROVE, $article);

        $this->dispatchSync(new ApproveArticle($article));

        $this->success('The article has been approved and is live on the site.', $article->title());

        return redirect()->route('articles.show', $article->slug());
    }

    public function disapprove(Article $article): RedirectResponse
    {
        $this->authorize(ArticlePolicy::DISAPPROVE, $article);

        $this->dispatchSync(new DisapproveArticle($article));

        $this->success('The article has been disapproved and removed from the site.', $article->title());

        return redirect()->route('articles.show', $article->slug());
    }

    public function decline(Article $article): RedirectResponse
    {
        $this->authorize(ArticlePolicy::DECLINE, $article);

        $this->dispatchSync(new DeclineArticle($article));

        return redirect()->route('articles.show', $article->slug());
    }

    public function togglePinnedStatus(Article $article): RedirectResponse
    {
        $this->authorize(ArticlePolicy::PINNED, $article);

        $article->is_pinned = ! $article->isPinned();
        $article->save();

        $this->success($article->isPinned() ? 'Article successfully pinned!' : 'Article successfully unpinned!');

        return redirect()->route('articles.show', $article->slug());
    }
}
