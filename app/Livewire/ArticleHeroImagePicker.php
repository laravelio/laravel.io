<?php

namespace App\Livewire;

use App\Exceptions\UnsplashRequestFailed;
use App\Models\Article;
use App\UnsplashClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

final class ArticleHeroImagePicker extends Component
{
    private const MIN_QUERY_LENGTH = 3;

    protected UnsplashClient $unsplash;

    public int $minimumQueryLength = self::MIN_QUERY_LENGTH;

    public string $query = '';

    public ?string $selectedImageId = null;

    public ?array $selectedImage = null;

    public array $images = [];

    public bool $isOpen = false;

    public ?string $error = null;

    public bool $hasSearched = false;

    public bool $isVerifiedAuthor = false;

    public int $page = 1;

    public int $totalPages = 1;

    public bool $isLoadingMore = false;

    public function boot(UnsplashClient $unsplash): void
    {
        $this->unsplash = $unsplash;
    }

    public function mount(?Article $article = null): void
    {
        $author = $article?->exists ? $article->author() : auth()->user();

        $this->isVerifiedAuthor = $author?->isVerifiedAuthor() ?? false;

        $this->selectedImageId = old('hero_image_id', $article?->hero_image_id);

        if ($article?->hero_image_id && $article?->hero_image_url) {
            $this->selectedImage = [
                'id' => $article->hero_image_id,
                'raw_url' => $article->hero_image_url,
                'author_name' => $article->hero_image_author_name,
                'author_url' => $article->hero_image_author_url,
            ];
        }
    }

    public function render(): View
    {
        return view('livewire.article-hero-image-picker');
    }

    public function updatedQuery(): void
    {
        $query = Str::of($this->query)->squish()->toString();

        if (strlen($query) < self::MIN_QUERY_LENGTH) {
            $this->resetSearch();

            return;
        }

        $this->startSearch();
        $this->page = 1;

        if (is_array($cachedResponse = Cache::get($cacheKey = $this->cacheKey($query, $this->page)))) {
            $this->images = $this->mapImages($cachedResponse);
            $this->totalPages = $cachedResponse['total_pages'] ?? 1;
            $this->finishSearch(resetScroll: true);

            return;
        }

        try {
            $response = $this->unsplash->searchPhotos($query, $this->page);

            $this->images = $this->mapImages($response);
            $this->totalPages = $response['total_pages'] ?? 1;
        } catch (UnsplashRequestFailed) {
            $this->images = [];
            $this->error = 'We could not load images from Unsplash. Please try again.';
        }

        if ($this->error === null) {
            Cache::put($cacheKey, $response, $this->cacheDuration());
        }

        $this->finishSearch(resetScroll: true);
    }

    public function loadMore(): void
    {
        if (! $this->canLoadMore() || $this->isLoadingMore) {
            return;
        }

        $this->isLoadingMore = true;

        try {
            $query = Str::of($this->query)->squish()->toString();
            $nextPage = $this->page + 1;
            $cacheKey = $this->cacheKey($query, $nextPage);

            if (is_array($cachedResponse = Cache::get($cacheKey))) {
                $this->page = $nextPage;
                $this->totalPages = $cachedResponse['total_pages'] ?? $this->totalPages;
                $this->images = [...$this->images, ...$this->mapImages($cachedResponse)];

                return;
            }

            $response = $this->unsplash->searchPhotos($query, $nextPage);

            $this->page = $nextPage;
            $this->totalPages = $response['total_pages'] ?? $this->totalPages;
            $this->images = [...$this->images, ...$this->mapImages($response)];

            Cache::put($cacheKey, $response, $this->cacheDuration());
        } catch (UnsplashRequestFailed) {
            $this->error = 'We could not load more images from Unsplash. Please try again.';
        } finally {
            $this->isLoadingMore = false;
        }
    }

    public function canLoadMore(): bool
    {
        return $this->hasSearched && $this->error === null && $this->page < $this->totalPages;
    }

    public function selectImage(string $imageId): void
    {
        $image = collect($this->images)->firstWhere('id', $imageId);

        if (! $image) {
            return;
        }

        $this->selectedImageId = $image['id'];
        $this->selectedImage = $image;
        $this->query = '';
        $this->resetSearch();
    }

    public function removeImage(): void
    {
        $this->selectedImageId = null;
        $this->selectedImage = null;
    }

    public function previewImageUrl(string $url, int $width = 200): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';

        return "{$url}{$separator}fit=max&w={$width}";
    }

    public function unsplashUrl(): string
    {
        return 'https://unsplash.com/?utm_source=Laravel.io&utm_medium=referral';
    }

    public function authorUrl(string $url): string
    {
        return "{$url}?utm_source=Laravel.io&utm_medium=referral";
    }

    private function resetSearch(): void
    {
        $this->images = [];
        $this->isOpen = false;
        $this->error = null;
        $this->hasSearched = false;
        $this->page = 1;
        $this->totalPages = 1;
        $this->isLoadingMore = false;
    }

    private function startSearch(): void
    {
        $this->isOpen = true;
        $this->error = null;
        $this->hasSearched = false;
    }

    private function finishSearch(bool $resetScroll = false): void
    {
        $this->hasSearched = true;

        if ($resetScroll) {
            $this->dispatch('unsplash-images-updated');
        }
    }

    private function cacheKey(string $query, int $page): string
    {
        return 'unsplash-search:'.md5(Str::lower($query)).":page:{$page}";
    }

    private function cacheDuration(): \DateTimeInterface
    {
        return now()->addHours(6);
    }

    private function mapImages(array $response): array
    {
        return collect($response['results'] ?? [])
            ->map(fn (array $image) => [
                'id' => $image['id'],
                'raw_url' => $image['urls']['raw'],
                'thumb_url' => $image['urls']['thumb'],
                'author_name' => $image['user']['name'],
                'author_url' => $image['user']['links']['html'],
            ])
            ->all();
    }
}
