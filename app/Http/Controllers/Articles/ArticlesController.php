<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\ArticleRequest;
use App\Jobs\CreateArticle;
use App\Jobs\DeleteArticle;
use App\Jobs\UpdateArticle;
use App\Models\Article;
use App\Models\Tag;
use App\Policies\ArticlePolicy;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class], ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return view('articles.index');
    }

    public function show(Article $article)
    {
        $user = Auth::user();

        abort_unless(
            $article->isPublished() || ($user && ($article->isAuthoredBy($user) || $user->isAdmin() || $user->isModerator())),
            404,
        );

        return view('articles.show', [
            'article' => $article,
        ]);
    }

    public function create()
    {
        return view('articles.create', [
            'tags' => Tag::all(),
            'selectedTags' => old('tags', []),
        ]);
    }

    public function store(ArticleRequest $request)
    {
        $article = $this->dispatchNow(CreateArticle::fromRequest($request));

        $this->success($request->shouldBeSubmitted() ? 'articles.submitted' : 'articles.created');

        return redirect()->route('articles.show', $article->slug());
    }

    public function edit(Article $article)
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        return view('articles.edit', [
            'article' => $article,
            'tags' => Tag::all(),
            'selectedTags' => old('tags', $article->tags()->pluck('id')->toArray()),
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        $wasNotPreviouslySubmitted = $article->isNotSubmitted();

        $article = $this->dispatchNow(UpdateArticle::fromRequest($article, $request));

        if ($wasNotPreviouslySubmitted && $request->shouldBeSubmitted()) {
            $this->success('articles.submitted');
        } else {
            $this->success('articles.updated');
        }

        return redirect()->route('articles.show', $article->slug());
    }

    public function delete(Article $article)
    {
        $this->authorize(ArticlePolicy::DELETE, $article);

        $this->dispatchNow(new DeleteArticle($article));

        $this->success('articles.deleted');

        return redirect()->route('articles');
    }
}
