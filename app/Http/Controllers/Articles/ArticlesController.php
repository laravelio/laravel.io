<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfUnconfirmed;
use App\Models\Article;

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
    
    }

    public function store()
    {
    
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
