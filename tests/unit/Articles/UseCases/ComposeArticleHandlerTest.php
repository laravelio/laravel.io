<?php namespace Lio\Articles\UseCases;

use Lio\Accounts\Member;
use Lio\Articles\Article;
use Lio\Articles\EloquentArticleRepository;
use Lio\Laravel\Laravel;
use Mockery as m;

class ComposeArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleHandler', $this->getHandler());
    }

    public function test_can_compose_article()
    {
        $articleRepository = m::mock('Lio\Articles\ArticleRepository');
        $articleRepository->shouldReceive('save')->andReturn(true);
        $handler = $this->getHandler($articleRepository);
        $request = new ComposeArticleRequest(new Member, 'title', 'content', Article::STATUS_PUBLISHED, Laravel::$versions[4]);
        $response = $handler->handle($request);

        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleResponse', $response);
        $this->assertEquals('title', $response->article->title);
        $this->assertEquals('content', $response->article->content);
        $this->assertEquals(Article::STATUS_PUBLISHED, $response->article->status);
        $this->assertEquals(Laravel::$versions[4], $response->article->laravel_version);
    }

    private function getHandler($articleRepository = null)
    {
        return new ComposeArticleHandler($articleRepository ?: new EloquentArticleRepository(new Article));
    }
} 
