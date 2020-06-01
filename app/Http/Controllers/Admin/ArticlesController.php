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
}
