<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Jobs\ApproveArticle;
use App\Jobs\DeclineArticle;
use App\Jobs\DisapproveArticle;
use App\Models\Article;
use App\Policies\ArticlePolicy;
use App\Queries\SearchArticles;
use Illuminate\Auth\Middleware\Authenticate;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function index()
    {
        if ($adminSearch = request('admin_search')) {
            $articles = SearchArticles::get($adminSearch)->appends(['admin_search' => $adminSearch]);
        } else {
            $articles = Article::awaitingApproval()
                ->orderByDesc('submitted_at')
                ->paginate();
        }

        return view('admin.articles', compact('articles', 'adminSearch'));
    }

    public function approve(Article $article)
    {
        $this->authorize(ArticlePolicy::APPROVE, $article);

        $this->dispatchNow(new ApproveArticle($article));

        $this->success('admin.articles.approved', $article->title());

        return redirect()->route('articles.show', $article->slug());
    }

    public function disapprove(Article $article)
    {
        $this->authorize(ArticlePolicy::DISAPPROVE, $article);

        $this->dispatchNow(new DisapproveArticle($article));

        $this->success('admin.articles.disapproved', $article->title());

        return redirect()->route('articles.show', $article->slug());
    }

    public function decline(Article $article)
    {
        $this->authorize(ArticlePolicy::DECLINE, $article);

        $this->dispatchNow(new DeclineArticle($article));

        $this->success('admin.articles.declined', $article->title());

        return redirect()->route('articles.show', $article->slug());
    }

    public function togglePinnedStatus(Article $article)
    {
        $this->authorize(ArticlePolicy::PINNED, $article);

        $article->is_pinned = ! $article->isPinned();
        $article->save();

        $this->success($article->isPinned() ? 'admin.articles.pinned' : 'admin.articles.unpinned');

        return redirect()->route('articles.show', $article->slug());
    }
}
