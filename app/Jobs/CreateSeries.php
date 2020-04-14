<?php

namespace App\Jobs;

use App\Http\Requests\SeriesRequest;
use App\Models\Series;
use App\User;

final class CreateSeries
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var array
     */
    private $tags;

    public function __construct(string $title, User $author, array $tags = [])
    {
        $this->title = $title;
        $this->author = $author;
        $this->tags = $tags;
    }

    public static function fromRequest(SeriesRequest $request): self
    {
        return new static(
            $request->title(),
            $request->author(),
            $request->tags()
        );
    }

    public function handle(): Series
    {
        $series = new Series([
            'title' => $this->title,
        ]);
        $series->authoredBy($this->author);
        $series->syncTags($this->tags);
        $series->save();

        return $series;
    }
}
