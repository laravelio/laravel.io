<?php namespace unit\Articles\UseCases; 

use Lio\Articles\Article;
use Lio\Articles\EloquentArticleRepository;
use Lio\Articles\UseCases\EditArticleHandler;
use Lio\Articles\UseCases\EditArticleRequest;
use Lio\Laravel\Laravel;
use Mockery as m;

class EditArticleHandlerTest extends \UnitTestCase
{
    public function test_can_create_handler()
    {
        $this->assertInstanceOf('Lio\Articles\UseCases\EditArticleHandler', $this->getHandler());
    }

    public function test_can_edit_article()
    {
        $articleRepository = m::mock('Lio\Articles\ArticleRepository');
        $articleRepository->shouldReceive('requireById')->andReturn(new Article);
        $articleRepository->shouldReceive('save');
        $handler = $this->getHandler($articleRepository);
        $request = new EditArticleRequest(1, 'title2', 'content2');
        $response = $handler->handle($request);
        $this->assertInstanceOf('Lio\Articles\UseCases\EditArticleResponse', $response);
        $this->assertEquals('title2', $response->article->title);
        $this->assertEquals('content2', $response->article->content);
    }

    private function getHandler($articleRepository = null)
    {
        return new EditArticleHandler($articleRepository ?: new EloquentArticleRepository(new Article));
    }
}
