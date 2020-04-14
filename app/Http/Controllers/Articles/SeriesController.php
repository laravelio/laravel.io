<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfUnconfirmed;
use App\Http\Requests\SeriesRequest;
use App\Jobs\CreateSeries;
use App\Models\Tag;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class], ['except' => ['index', 'show']]);
    }

    public function create()
    {
        $tags = Tag::all();
        $selectedTags = old('tags') ?: [];

        return view('articles.series.create', ['tags' => $tags, 'selectedTags' => $selectedTags]);
    }

    public function store(SeriesRequest $request)
    {
        $series = $this->dispatchNow(CreateSeries::fromRequest($request));

        $this->success('series.created');

        return redirect()->route('series.show', $series->id());
    }
}