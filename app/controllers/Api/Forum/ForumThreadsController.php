<?php namespace Api;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use URL;
use Input;
use BaseController;
use Lio\Tags\TagRepository;
use Lio\Forum\EloquentThreadRepository;

class ForumThreadsController extends BaseController
{
    protected $tags;
    protected $threads;
    protected $threadsPerPage = 50;
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * @var UrlGenerator
     */
    private $url;

    public function __construct(EloquentThreadRepository $threads, TagRepository $tags, Request $request, UrlGenerator $url)
    {
        $this->threads = $threads;
        $this->tags = $tags;
        $this->request = $request;
        $this->url = $url;
    }

    public function getIndex($status = '')
    {
        $threadCount = $this->request->get('take', $this->threadsPerPage);
        $tags = $this->tags->getAllTagsBySlug($this->request->get('tags'));
        $threads = $this->threads->getByTagsAndStatusPaginated($tags, $status, $threadCount);

        $collection = $threads->getCollection();

        $collection->each(function($thread) {
            $thread->url = $this->url->action('ForumThreadsController@getShow', ['slug' => $thread->slug]);
        });

        // We want the newest threads to come out in chronological order
        return $collection->reverse();
    }
}
