<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfUnconfirmed;
use App\Http\Requests\SeriesRequest;
use App\Jobs\CreateSeries;
use App\Jobs\DeleteSeries;
use App\Jobs\UpdateSeries;
use App\Models\Series;
use App\Models\Tag;
use App\Policies\SeriesPolicy;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware([Authenticate::class, RedirectIfUnconfirmed::class], ['except' => ['index', 'show']]);
    }

    public function index()
    {
    }

    public function show(Series $series)
    {
    }

    public function create()
    {
        $tags = Tag::all();
        $selectedTags = old('tags') ?: [];

        return view('series.create', ['tags' => $tags, 'selectedTags' => $selectedTags]);
    }

    public function store(SeriesRequest $request)
    {
        $series = $this->dispatchNow(CreateSeries::fromRequest($request));

        $this->success('series.created');

        return redirect()->route('series.show', $series->slug());
    }

    public function edit(Series $series)
    {
        $this->authorize(SeriesPolicy::UPDATE, $series);
        $selectedTags = $series->tags()->pluck('id')->toArray();

        return view('series.edit', ['series' => $series, 'tags' => Tag::all(), 'selectedTags' => $selectedTags]);
    }

    public function update(SeriesRequest $request, Series $series)
    {
        $this->authorize(SeriesPolicy::UPDATE, $series);

        $series = $this->dispatchNow(UpdateSeries::fromRequest($series, $request));

        $this->success('series.updated');

        return redirect()->route('series.show', $series->slug());
    }

    public function delete(Series $series)
    {
        $this->authorize(SeriesPolicy::DELETE, $series);

        $this->dispatchNow(new DeleteSeries($series));

        $this->success('series.deleted');

        return redirect()->route('series');
    }
}
