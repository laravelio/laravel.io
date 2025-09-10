<?php

namespace App\Http\Controllers\Articles;

use App\Concerns\UsesFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Jobs\CreateArticle;
use App\Jobs\DeleteArticle;
use App\Jobs\UpdateArticle;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\Policies\ArticlePolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ArticlesController extends Controller
{
    use UsesFilters;

    public function __construct()
    {
        $this->middleware([Authenticate::class, EnsureEmailIsVerified::class], ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $filter = $this->getFilter(['recent', 'popular', 'trending']);

        $pinnedArticles = Article::published()
            ->pinned()
            ->latest('approved_at')
            ->take(4)
            ->get();

        $articles = Article::published()
            ->latest('approved_at')
            ->{$filter}();

        $tags = Tag::whereHas('articles', fn ($query) => $query->published())
            ->orderBy('name')
            ->get();

        if ($activeTag = Tag::where('slug', $request->tag)->first()) {
            $articles->forTag($activeTag->slug());
        }

        $canonical = canonical('articles', ['filter' => $filter, 'tag' => $activeTag?->slug()]);
        $topAuthors = Cache::remember(
            'topAuthors', 
            now()->addMinutes(30),
            fn () => User::mostSubmissionsInLastDays(365)->take(5)->get()
        );

        return view('articles.overview', [
            'pinnedArticles' => $pinnedArticles,
            'articles' => $articles->paginate(10),
            'tags' => $tags,
            'activeTag' => $activeTag,
            'filter' => $filter,
            'canonical' => $canonical,
            'topAuthors' => $topAuthors,
        ]);
    }

    public function show(Article $article): View
    {
        $user = Auth::user();

        abort_unless(
            $article->isPublished() || ($user && ($article->isAuthoredBy($user) || $user->isAdmin() || $user->isModerator())),
            404,
        );

        $trendingArticles = Article::published()
            ->trending()
            ->whereKeyNot($article->id)
            ->limit(3)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'trendingArticles' => $trendingArticles,
        ]);
    }

    public function create(Request $request): View
    {
        $tags = Tag::query();

        if (! $request->user()->isAdmin()) {
            $tags = $tags->public();
        }

        return view('articles.create', [
            'tags' => $tags->get(),
            'selectedTags' => old('tags', []),
        ]);
    }

    public function store(ArticleRequest $request)
    {
        $this->dispatchSync(CreateArticle::fromRequest($request, $uuid = Str::uuid()));

        $article = Article::findByUuidOrFail($uuid);

        if ($article->isNotApproved()) {
            $this->success(
                $request->shouldBeSubmitted()
                    ? 'Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.'
                    : 'Article successfully created!'
            );
        }

        return $request->wantsJson()
            ? ArticleResource::make($article)
            : redirect()->route('articles.show', $article->slug());
    }

    public function edit(Request $request, Article $article): View
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        $tags = Tag::query();

        if (! $request->user()->isAdmin()) {
            $tags = $tags->public();
        }

        return view('articles.edit', [
            'article' => $article,
            'tags' => $tags->get(),
            'selectedTags' => old('tags', $article->tags()->pluck('id')->toArray()),
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize(ArticlePolicy::UPDATE, $article);

        $wasNotPreviouslySubmitted = $article->isNotSubmitted();

        $this->dispatchSync(UpdateArticle::fromRequest($article, $request));

        $article = $article->fresh();

        if ($wasNotPreviouslySubmitted && $request->shouldBeSubmitted() && $article->isNotApproved()) {
            $this->success('Thank you for submitting, unfortunately we can\'t accept every submission. You\'ll only hear back from us when we accept your article.');
        } else {
            $this->success('Article successfully updated!');
        }

        return $request->wantsJson()
            ? ArticleResource::make($article)
            : redirect()->route('articles.show', $article->slug());
    }

    public function delete(Request $request, Article $article)
    {
        $this->authorize(ArticlePolicy::DELETE, $article);

        $this->dispatchSync(new DeleteArticle($article));

        $this->success('Article successfully deleted!');

        return $request->wantsJson()
            ? response()->json([], Response::HTTP_NO_CONTENT)
            : redirect()->route('articles');
    }
}
