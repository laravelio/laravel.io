<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfUnconfirmed;
use App\Http\Requests\ArticleRequest;
use App\Jobs\CreateArticle;
use App\Models\Article;
use App\Models\Tag;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class], ['except' => ['index', 'show']]);
    }

    public function index()
    {
    
    }

    public function show(Article $article)
    {
        
    }

    public function create()
    {
        $tags = Tag::all();
        $selectedTags = old('tags') ?: [];

        return view('articles.create', ['tags' => $tags, 'selectedTags' => $selectedTags]);
    }

    public function store(ArticleRequest $request)
    {
        $article = $this->dispatchNow(CreateArticle::fromRequest($request));

        $this->success('articles.created');

        return redirect()->route('articles.show', $article->slug());
    }

    public function edit(Article $article)
    {

    }

    public function update(Article $article)
    {

    }

    public function delete(Article $article)
    {

    }
}
