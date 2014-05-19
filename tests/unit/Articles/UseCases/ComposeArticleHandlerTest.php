<?php namespace Lio\Articles\UseCases;

use Lio\Accounts\Member;
use Lio\Articles\Article;
use Lio\Articles\EloquentArticleRepository;
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
        $request = new ComposeArticleRequest(new Member, 'title', 'content', 1, 4);
        $this->assertInstanceOf('Lio\Articles\UseCases\ComposeArticleResponse', $handler->handle($request));
    }

    private function getHandler($articleRepository = null)
    {
        return new ComposeArticleHandler($articleRepository ?: new EloquentArticleRepository(new Article));
    }
} 
