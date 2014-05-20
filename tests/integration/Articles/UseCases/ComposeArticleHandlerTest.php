<?php namespace Lio\Articles\UseCases;

use Mockery as m;
use Lio\Laravel\Laravel;
use Lio\Accounts\Member;
use Lio\Articles\Entities\Article;
use Lio\Articles\StubbedArticleRepository;

class ComposeArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleHandler', $this->getHandler());
    }

    public function test_can_compose_article()
    {
        $articleRepository = m::mock('Lio\Articles\Repositories\ArticleRepository');
        $articleRepository->shouldReceive('save')->andReturn(true);

        $handler = $this->getHandler($articleRepository);
        $request = new ComposeArticleRequest(new Member, 'beep boop', 'content', Article::STATUS_PUBLISHED, Laravel::$versions[4]);
        $response = $handler->handle($request);

        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleResponse', $response);
        $this->assertInstanceOf('Lio\Articles\Entities\Article', $response->article);
        $this->assertEquals('beep boop', $response->article->title);
        $this->assertEquals('content', $response->article->content);
        $this->assertEquals(Article::STATUS_PUBLISHED, $response->article->status);
        $this->assertEquals(Laravel::$versions[4], $response->article->laravel_version);
    }

    private function getHandler($articleRepository = null)
    {
        return new ComposeArticleHandler($articleRepository ?: new StubbedArticleRepository);
    }
} 
