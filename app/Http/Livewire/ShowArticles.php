<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

final class ShowArticles extends Component
{
    use WithPagination;

    public $tag;

    public $sortBy = 'recent';

    protected $queryString = [
        'tag' => ['except' => ''],
        'sortBy' => ['except' => 'recent'],
    ];

    public function render(): View
    {
        $this->sortBy($this->sortBy);
        $articles = Article::published()
            ->notPinned();

        $tags = Tag::whereHas('articles', function ($query) {
            $query->published();
        })->orderBy('name')->get();

        $selectedTag = Tag::where('name', $this->tag)->first();

        if ($this->tag) {
            $articles->forTag($this->tag);
        }

        $articles->{$this->sortBy}();

        return view('livewire.show-articles', [
            'articles' => $articles->paginate(10),
            'tags' => $tags,
            'selectedTag' => $selectedTag,
            'selectedSortBy' => $this->sortBy,
        ]);
    }

    public function toggleTag($tag): void
    {
        $this->tag = $this->tag !== $tag && $this->tagExists($tag) ? $tag : null;
    }

    public function sortBy($sort): void
    {
        $this->sortBy = $this->validSort($sort) ? $sort : 'recent';
    }

    public function tagExists($tag): bool
    {
        return Tag::where('slug', $tag)->exists();
    }

    public function validSort($sort): bool
    {
        return in_array($sort, [
            'recent',
            'popular',
            'trending',
        ]);
    }
}
