<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyAdmins;
use App\Jobs\ApproveArticle;
use App\Jobs\DisapproveArticle;
use App\Models\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Auth\Middleware\Authenticate;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, VerifyAdmins::class]);
    }

    public function index()
    {
        $articles = Article::awaitingApproval()
            ->orderBy('submitted_at', 'asc')
            ->paginate();

        return view('admin.articles', [
            'articles' => $articles,
        ]);
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

    public function togglePinnedStatus(Article $article)
    {
        $this->authorize(ArticlePolicy::PINNED, $article);

        $article->is_pinned = ! $article->isPinned();
        $article->save();

        $this->success($article->isPinned() ? 'admin.articles.pinned' : 'admin.articles.unpinned');

        return redirect()->route('articles.show', $article->slug());
    }
}
